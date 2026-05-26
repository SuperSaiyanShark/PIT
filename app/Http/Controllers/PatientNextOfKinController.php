<?php

namespace App\Http\Controllers;

use App\Models\PatientNextOfKin;
use App\Models\Patient;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PatientNextOfKinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nextOfKins = PatientNextOfKin::with('patient')->paginate(15);
        return Inertia::render('Module1/PatientNextOfKin/Index', compact('nextOfKins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::all();
        return Inertia::render('Module1/PatientNextOfKin/Create', compact('patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'full_name' => 'required|string|max:255',
            'relationship' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:20',
        ]);

        PatientNextOfKin::create($validated);

        return redirect()->route('patient-next-of-kin.index')->with('success', 'Next of Kin added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PatientNextOfKin $patientNextOfKin)
    {
        $patientNextOfKin->load('patient');
        return Inertia::render('Module1/PatientNextOfKin/Show', compact('patientNextOfKin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PatientNextOfKin $patientNextOfKin)
    {
        $patients = Patient::all();
        $nextOfKin = $patientNextOfKin;
        return Inertia::render('Module1/PatientNextOfKin/Edit', compact('nextOfKin', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PatientNextOfKin $patientNextOfKin)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'full_name' => 'required|string|max:255',
            'relationship' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $patientNextOfKin->update($validated);

        return redirect()->route('patient-next-of-kin.index')->with('success', 'Next of Kin updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PatientNextOfKin $patientNextOfKin)
    {
        $patientNextOfKin->delete();
        return redirect()->route('patient-next-of-kin.index')->with('success', 'Next of Kin deleted successfully.');
    }
}
