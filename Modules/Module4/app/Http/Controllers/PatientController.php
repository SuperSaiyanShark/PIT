<?php

namespace Modules\Module4\app\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::latest()->paginate(15);

        return Inertia::render('Module4::Patients/Index', [
            'patients' => $patients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Module4::Patients/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'ward_id'           => 'nullable|exists:wards,id',
            'allocation_id'     => 'nullable|integer',
            'date_admitted'     => 'nullable|date',
            'expected_duration' => 'nullable|integer|min:0',
            'date_expected_leave' => 'nullable|date|after_or_equal:date_admitted',
            'status'            => 'nullable|string|max:50',
        ]);

        $patient = Patient::create($validated);

        return redirect()->route('patients.show', $patient)
                         ->with('success', 'Patient created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return Inertia::render('Module4::Patients/Show', [
            'patient' => $patient,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return Inertia::render('Module4::Patients/Edit', [
            'patient' => $patient,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'ward_id'           => 'nullable|exists:wards,id',
            'allocation_id'     => 'nullable|integer',
            'date_admitted'     => 'nullable|date',
            'expected_duration' => 'nullable|integer|min:0',
            'date_expected_leave' => 'nullable|date|after_or_equal:date_admitted',
            'status'            => 'nullable|string|max:50',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.show', $patient)
                         ->with('success', 'Patient updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')
                         ->with('success', 'Patient deleted successfully!');
    }
}
