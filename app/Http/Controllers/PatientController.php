<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\NextOfKin;
use App\Models\MedicalRecord;
use App\Models\Admission;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with(['nextOfKin', 'latestAdmission.ward']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('first_name', 'ilike', "%$s%")
                  ->orWhere('last_name',  'ilike', "%$s%")
                  ->orWhere('phone_number', 'ilike', "%$s%")
                  ->orWhereRaw("CAST(id AS TEXT) ILIKE ?", ["%$s%"]);
            });
        }

        $patients = $query->orderBy('created_at', 'desc')->get()->map(function ($p) {
            return [
                'id'                => $p->id,
                'first_name'        => $p->first_name,
                'last_name'         => $p->last_name,
                'full_name'         => $p->full_name,
                'age'               => $p->age,
                'sex'               => $p->sex,
                'marital_status'    => $p->marital_status,
                'address'           => $p->address,
                'phone_number'      => $p->phone_number,
                'email'             => $p->email,
                'blood_type'        => $p->blood_type,
                'allergies'         => $p->allergies,
                'medical_conditions'=> $p->medical_conditions,
                'date_of_birth'     => $p->date_of_birth?->format('Y-m-d'),
                'date_registered'   => $p->date_registered?->format('Y-m-d'),
                'status'            => $p->status,
                'bed_number'        => optional($p->latestAdmission)->bed_number,
                'ward_name'         => optional(optional($p->latestAdmission)->ward)->name,
                'next_of_kin'       => $p->nextOfKin,
            ];
        });

        $stats = [
            'total'            => Patient::count(),
            'admitted'         => Admission::whereNull('date_actual_leave')->count(),
            'discharged_today' => Admission::whereDate('date_actual_leave', today())->count(),
            'beds_available'   => Ward::all()->sum(fn($w) => max(0, ($w->capacity ?? 0) - Admission::where('ward_id', $w->id)->whereNull('date_actual_leave')->count())),
        ];

        $wards = Ward::all(['id', 'name', 'floor', 'capacity']);

        return Inertia::render('Patients/Index', [
            'patients' => $patients,
            'stats'    => $stats,
            'wards'    => $wards,
            'filters'  => $request->only(['search']),
        ]);
    }

    public function show(Patient $patient)
    {
        $patient->load([
            'nextOfKin',
            'medicalRecords' => fn($q) => $q->orderBy('record_date', 'desc'),
            'admissions'     => fn($q) => $q->with('ward')->orderBy('date_admitted', 'desc'),
        ]);

        $wards = Ward::all(['id', 'name', 'floor', 'capacity']);

        return Inertia::render('Patients/Show', [
            'patient' => [
                'id'                => $patient->id,
                'first_name'        => $patient->first_name,
                'last_name'         => $patient->last_name,
                'full_name'         => $patient->full_name,
                'age'               => $patient->age,
                'sex'               => $patient->sex,
                'marital_status'    => $patient->marital_status,
                'address'           => $patient->address,
                'phone_number'      => $patient->phone_number,
                'email'             => $patient->email,
                'blood_type'        => $patient->blood_type,
                'allergies'         => $patient->allergies,
                'medical_conditions'=> $patient->medical_conditions,
                'date_of_birth'     => $patient->date_of_birth?->format('Y-m-d'),
                'date_registered'   => $patient->date_registered?->format('Y-m-d'),
                'status'            => $patient->status,
                'next_of_kin'       => $patient->nextOfKin,
                'medical_records'   => $patient->medicalRecords,
                'admissions'        => $patient->admissions->map(fn($a) => [
                    'id'                   => $a->id,
                    'ward_id'              => $a->ward_id,
                    'ward_name'            => optional($a->ward)->name,
                    'bed_number'           => $a->bed_number,
                    'date_on_waiting_list' => $a->date_on_waiting_list?->format('Y-m-d'),
                    'expected_stay_days'   => $a->expected_stay_days,
                    'date_admitted'        => $a->date_admitted?->format('Y-m-d'),
                    'date_expected_leave'  => $a->date_expected_leave?->format('Y-m-d'),
                    'date_actual_leave'    => $a->date_actual_leave?->format('Y-m-d'),
                    'discharge_notes'      => $a->discharge_notes,
                    'status'               => is_null($a->date_actual_leave) ? 'Admitted' : 'Discharged',
                ]),
            ],
            'wards' => $wards,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'        => 'required|string|max:100',
            'last_name'         => 'required|string|max:100',
            'date_of_birth'     => 'required|date|before:today',
            'sex'               => 'required|in:M,F',
            'marital_status'    => 'nullable|in:Single,Married,Widowed,Separated',
            'address'           => 'nullable|string|max:255',
            'phone_number'      => 'nullable|string|max:30',
            'email'             => 'nullable|email|max:100',
            'blood_type'        => 'nullable|string|max:10',
            'allergies'         => 'nullable|string|max:255',
            'medical_conditions'=> 'nullable|string|max:255',
            'nok_full_name'     => 'nullable|string|max:150',
            'nok_relationship'  => 'nullable|string|max:50',
            'nok_address'       => 'nullable|string|max:255',
            'nok_phone'         => 'nullable|string|max:30',
        ]);

        DB::transaction(function () use ($validated) {
            $patient = Patient::create([
                ...$validated,
                'date_registered' => today(),
            ]);

            if (!empty($validated['nok_full_name'])) {
                NextOfKin::create([
                    'patient_id'   => $patient->id,
                    'full_name'    => $validated['nok_full_name'],
                    'relationship' => $validated['nok_relationship'] ?? null,
                    'address'      => $validated['nok_address'] ?? null,
                    'phone_number' => $validated['nok_phone'] ?? null,
                ]);
            }
        });

        return back()->with('success', 'Patient registered successfully.');
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'first_name'        => 'required|string|max:100',
            'last_name'         => 'required|string|max:100',
            'date_of_birth'     => 'required|date|before:today',
            'sex'               => 'required|in:M,F',
            'marital_status'    => 'nullable|in:Single,Married,Widowed,Separated',
            'address'           => 'nullable|string|max:255',
            'phone_number'      => 'nullable|string|max:30',
            'email'             => 'nullable|email|max:100',
            'blood_type'        => 'nullable|string|max:10',
            'allergies'         => 'nullable|string|max:255',
            'medical_conditions'=> 'nullable|string|max:255',
            'nok_full_name'     => 'nullable|string|max:150',
            'nok_relationship'  => 'nullable|string|max:50',
            'nok_address'       => 'nullable|string|max:255',
            'nok_phone'         => 'nullable|string|max:30',
        ]);

        DB::transaction(function () use ($validated, $patient) {
            $patient->update($validated);

            if (!empty($validated['nok_full_name'])) {
                NextOfKin::updateOrCreate(
                    ['patient_id' => $patient->id],
                    [
                        'full_name'    => $validated['nok_full_name'],
                        'relationship' => $validated['nok_relationship'] ?? null,
                        'address'      => $validated['nok_address'] ?? null,
                        'phone_number' => $validated['nok_phone'] ?? null,
                    ]
                );
            }
        });

        return back()->with('success', 'Patient updated successfully.');
    }

    public function storeMedicalRecord(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'diagnosis'   => 'required|string|max:255',
            'treatment'   => 'nullable|string|max:255',
            'record_date' => 'required|date',
            'notes'       => 'nullable|string',
        ]);

        MedicalRecord::create(['patient_id' => $patient->id, ...$validated]);

        return back()->with('success', 'Medical record added.');
    }

    public function admit(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'ward_id'       => 'required|exists:wards,id',
            'bed_number'    => 'required|string|max:20',
            'date_admitted' => 'required|date',
        ]);

        if (Admission::where('patient_id', $patient->id)->whereNull('date_actual_leave')->exists()) {
            return back()->with('error', 'Patient is already admitted.');
        }

        Admission::create([
            'patient_id'           => $patient->id,
            'ward_id'              => $validated['ward_id'],
            'bed_number'           => $validated['bed_number'],
            'date_on_waiting_list' => today(),
            'date_admitted'        => $validated['date_admitted'],
            'date_expected_leave'  => null,
        ]);

        return back()->with('success', 'Patient admitted successfully.');
    }

    public function discharge(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'discharge_notes' => 'nullable|string',
        ]);

        $admission = Admission::where('patient_id', $patient->id)
                               ->whereNull('date_actual_leave')
                               ->first();

        if (!$admission) {
            return back()->with('error', 'No active admission found.');
        }

        $admission->update([
            'date_actual_leave' => today(),
            'discharge_notes'   => $validated['discharge_notes'] ?? null,
        ]);

        return back()->with('success', 'Patient discharged successfully.');
    }
}
