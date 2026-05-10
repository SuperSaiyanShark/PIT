<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\NextOfKin;
use App\Models\MedicalRecord;
use App\Models\Ward;
use App\Models\Admission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with(['latestAdmission.ward']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('FirstName', 'ilike', "%{$search}%")
                  ->orWhere('LastName', 'ilike', "%{$search}%")
                  ->orWhere('PhoneNumber', 'ilike', "%{$search}%")
                  ->orWhereRaw('"PatientID"::text ilike ?', ["%{$search}%"]);
            });
        }

        $patients = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $stats = [
            'total'        => Patient::count(),
            'admitted'     => Admission::where('Status', 'Admitted')->count(),
            'discharged_today' => Admission::where('Status', 'Discharged')
                                    ->whereDate('DischargeDate', today())->count(),
            'beds_available'   => Ward::all()->sum('available_beds'),
        ];

        $wards = Ward::all();

        return view('patients.index', compact('patients', 'stats', 'wards'));
    }

    public function show(Patient $patient)
    {
        $patient->load([
            'nextOfKin',
            'medicalRecords' => fn($q) => $q->orderBy('RecordDate', 'desc'),
            'admissions' => fn($q) => $q->with('ward')->orderBy('AdmissionDate', 'desc'),
        ]);

        $wards = Ward::orderBy('WardName')->get();

        return view('patients.show', compact('patient', 'wards'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'FirstName'         => 'required|string|max:100',
            'LastName'          => 'required|string|max:100',
            'DOB'               => 'required|date|before:today',
            'Sex'               => 'required|string|in:Male,Female,Other',
            'Address'           => 'nullable|string|max:255',
            'PhoneNumber'       => 'nullable|string|max:30',
            'Email'             => 'nullable|email|max:100',
            'BloodType'         => 'nullable|string|max:10',
            'Allergies'         => 'nullable|string|max:255',
            'MedicalConditions' => 'nullable|string|max:255',
            // Next of kin fields
            'nok_FullName'      => 'nullable|string|max:150',
            'nok_Relationship'  => 'nullable|string|max:50',
            'nok_Address'       => 'nullable|string|max:255',
            'nok_PhoneNumber'   => 'nullable|string|max:30',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $patient = Patient::create([
                'FirstName'         => $validated['FirstName'],
                'LastName'          => $validated['LastName'],
                'DOB'               => $validated['DOB'],
                'Sex'               => $validated['Sex'],
                'Address'           => $validated['Address'] ?? null,
                'PhoneNumber'       => $validated['PhoneNumber'] ?? null,
                'Email'             => $validated['Email'] ?? null,
                'BloodType'         => $validated['BloodType'] ?? null,
                'Allergies'         => $validated['Allergies'] ?? null,
                'MedicalConditions' => $validated['MedicalConditions'] ?? null,
                'DateRegistered'    => today(),
            ]);

            if (!empty($validated['nok_FullName'])) {
                NextOfKin::create([
                    'PatientID'    => $patient->PatientID,
                    'FullName'     => $validated['nok_FullName'],
                    'Relationship' => $validated['nok_Relationship'] ?? null,
                    'Address'      => $validated['nok_Address'] ?? null,
                    'PhoneNumber'  => $validated['nok_PhoneNumber'] ?? null,
                ]);
            }
        });

        return redirect()->route('patients.index')->with('success', 'Patient registered successfully.');
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'FirstName'         => 'required|string|max:100',
            'LastName'          => 'required|string|max:100',
            'DOB'               => 'required|date|before:today',
            'Sex'               => 'required|string|in:Male,Female,Other',
            'Address'           => 'nullable|string|max:255',
            'PhoneNumber'       => 'nullable|string|max:30',
            'Email'             => 'nullable|email|max:100',
            'BloodType'         => 'nullable|string|max:10',
            'Allergies'         => 'nullable|string|max:255',
            'MedicalConditions' => 'nullable|string|max:255',
            'nok_FullName'      => 'nullable|string|max:150',
            'nok_Relationship'  => 'nullable|string|max:50',
            'nok_Address'       => 'nullable|string|max:255',
            'nok_PhoneNumber'   => 'nullable|string|max:30',
        ]);

        DB::transaction(function () use ($validated, $patient) {
            $patient->update([
                'FirstName'         => $validated['FirstName'],
                'LastName'          => $validated['LastName'],
                'DOB'               => $validated['DOB'],
                'Sex'               => $validated['Sex'],
                'Address'           => $validated['Address'] ?? null,
                'PhoneNumber'       => $validated['PhoneNumber'] ?? null,
                'Email'             => $validated['Email'] ?? null,
                'BloodType'         => $validated['BloodType'] ?? null,
                'Allergies'         => $validated['Allergies'] ?? null,
                'MedicalConditions' => $validated['MedicalConditions'] ?? null,
            ]);

            if (!empty($validated['nok_FullName'])) {
                NextOfKin::updateOrCreate(
                    ['PatientID' => $patient->PatientID],
                    [
                        'FullName'     => $validated['nok_FullName'],
                        'Relationship' => $validated['nok_Relationship'] ?? null,
                        'Address'      => $validated['nok_Address'] ?? null,
                        'PhoneNumber'  => $validated['nok_PhoneNumber'] ?? null,
                    ]
                );
            }
        });

        return redirect()->route('patients.show', $patient)->with('success', 'Patient updated successfully.');
    }

    public function storeMedicalRecord(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'Diagnosis'  => 'required|string|max:255',
            'Treatment'  => 'nullable|string|max:255',
            'RecordDate' => 'required|date',
            'Notes'      => 'nullable|string',
        ]);

        MedicalRecord::create([
            'PatientID'  => $patient->PatientID,
            'Diagnosis'  => $validated['Diagnosis'],
            'Treatment'  => $validated['Treatment'] ?? null,
            'RecordDate' => $validated['RecordDate'],
            'Notes'      => $validated['Notes'] ?? null,
        ]);

        return redirect()->route('patients.show', $patient)->with('success', 'Medical record added.');
    }

    public function storeAdmission(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'WardID'        => 'required|exists:wards,WardID',
            'BedNumber'     => 'required|string|max:20',
            'AdmissionDate' => 'required|date',
        ]);

        // Check if already admitted
        $active = Admission::where('PatientID', $patient->PatientID)
                            ->where('Status', 'Admitted')->first();
        if ($active) {
            return back()->with('error', 'Patient is already admitted.');
        }

        Admission::create([
            'PatientID'     => $patient->PatientID,
            'WardID'        => $validated['WardID'],
            'BedNumber'     => $validated['BedNumber'],
            'AdmissionDate' => $validated['AdmissionDate'],
            'Status'        => 'Admitted',
        ]);

        return redirect()->route('patients.show', $patient)->with('success', 'Patient admitted successfully.');
    }

    public function discharge(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'DischargeNotes' => 'nullable|string',
        ]);

        $admission = Admission::where('PatientID', $patient->PatientID)
                               ->where('Status', 'Admitted')->first();

        if (!$admission) {
            return back()->with('error', 'No active admission found.');
        }

        $admission->update([
            'Status'         => 'Discharged',
            'DischargeDate'  => today(),
            'DischargeNotes' => $validated['DischargeNotes'] ?? null,
        ]);

        return redirect()->route('patients.show', $patient)->with('success', 'Patient discharged successfully.');
    }
}
