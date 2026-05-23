<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Ward;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('ward')->get();
        $wards = Ward::all();
        
        return Inertia::render('Patients', [
            'patients' => $patients,
            'wards' => $wards,
        ]);
    }

    public function create()
    {
        $wards = Ward::all();
        
        return Inertia::render('Patients', [
            'wards' => $wards,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'allocation_id' => 'required|string|unique:patients',
            'ward_id' => 'required|exists:wards,id',
            'date_admitted' => 'required|date',
            'expected_duration' => 'required|integer|min:1',
            'date_expected_leave' => 'required|date',
            'status' => 'nullable|in:admitted,discharged,transferred',
        ]);

        Patient::create($validated);

        return back()->with('success', 'Patient added successfully.');
    }

    public function edit(Patient $patient)
    {
        $wards = Ward::all();
        
        return Inertia::render('Patients', [
            'patient' => $patient,
            'wards' => $wards,
        ]);
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'allocation_id' => 'required|string|unique:patients,allocation_id,' . $patient->id,
            'ward_id' => 'required|exists:wards,id',
            'date_admitted' => 'required|date',
            'expected_duration' => 'required|integer|min:1',
            'date_expected_leave' => 'required|date',
            'status' => 'nullable|in:admitted,discharged,transferred',
        ]);

        $patient->update($validated);

        return back()->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return back()->with('success', 'Patient deleted successfully.');
    }
}
