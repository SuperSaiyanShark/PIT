<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Patient;
use App\Models\Ward;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdmissionController extends Controller
{
    public function index()
    {
        $admissions = Admission::with(['patient', 'ward'])->get();
        
        return Inertia::render('Admissions/Index', [
            'admissions' => $admissions,
        ]);
    }

    public function create()
    {
        $patients = Patient::select('id', 'first_name', 'last_name', 'allocation_id')->get();
        $wards = Ward::all();
        
        return Inertia::render('Admissions/Create', [
            'patients' => $patients,
            'wards' => $wards,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'ward_id' => 'nullable|exists:wards,id',
            'bed_number' => 'nullable|string',
            'expected_stay_days' => 'nullable|integer|min:1',
            'date_admitted' => 'required|date',
            'date_expected_leave' => 'nullable|date|after_or_equal:date_admitted',
            'discharge_notes' => 'nullable|string',
        ]);

        $admission = Admission::create([
            'patient_id' => $validated['patient_id'],
            'ward_id' => $validated['ward_id'] ?? null,
            'bed_number' => $validated['bed_number'] ?? null,
            'expected_stay_days' => $validated['expected_stay_days'] ?? null,
            'date_admitted' => $validated['date_admitted'],
            'date_expected_leave' => $validated['date_expected_leave'] ?? null,
        ]);

        return redirect()->route('admissions.index')->with('message', 'Admission created successfully.');
    }

    public function show(Admission $admission)
    {
        $admission->load(['patient', 'ward']);
        
        return Inertia::render('Admissions/Show', [
            'admission' => $admission,
        ]);
    }

    public function edit(Admission $admission)
    {
        $admission->load(['patient', 'ward']);
        $patients = Patient::select('id', 'first_name', 'last_name', 'allocation_id')->get();
        $wards = Ward::all();
        
        return Inertia::render('Admissions/Edit', [
            'admission' => $admission,
            'patients' => $patients,
            'wards' => $wards,
        ]);
    }

    public function update(Request $request, Admission $admission)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'ward_id' => 'nullable|exists:wards,id',
            'bed_number' => 'nullable|string',
            'expected_stay_days' => 'nullable|integer|min:1',
            'date_admitted' => 'required|date',
            'date_expected_leave' => 'nullable|date|after_or_equal:date_admitted',
            'discharge_notes' => 'nullable|string',
        ]);

        $admission->update([
            'patient_id' => $validated['patient_id'],
            'ward_id' => $validated['ward_id'] ?? null,
            'bed_number' => $validated['bed_number'] ?? null,
            'expected_stay_days' => $validated['expected_stay_days'] ?? null,
            'date_admitted' => $validated['date_admitted'],
            'date_expected_leave' => $validated['date_expected_leave'] ?? null,
            'discharge_notes' => $validated['discharge_notes'] ?? null,
        ]);

        return redirect()->route('admissions.index')->with('message', 'Admission updated successfully.');
    }

    public function destroy(Admission $admission)
    {
        $admission->delete();
        
        return redirect()->route('admissions.index')->with('message', 'Admission deleted successfully.');
    }

    public function discharge(Request $request, Admission $admission)
    {
        $validated = $request->validate([
            'date_actual_leave' => 'required|date|after_or_equal:' . $admission->date_admitted,
            'discharge_notes' => 'nullable|string',
        ]);

        $admission->update([
            'date_actual_leave' => $validated['date_actual_leave'],
            'discharge_notes' => $validated['discharge_notes'] ?? $admission->discharge_notes,
        ]);

        return redirect()->route('admissions.index')->with('message', 'Patient discharged successfully.');
    }
}
