<?php

namespace Modules\Module3\app\Http\Controllers;

use Modules\Module3\app\Models\Responsibility;
use Modules\Module3\app\Models\User;
use Modules\Module3\app\Models\Department;
use Modules\Module3\app\Models\Ward;
use Modules\Module3\app\Models\Patient;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResponsibilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $responsibilities = Responsibility::with('staff', 'department', 'ward')->get();
        $patients = Patient::with('ward')->get();
        
        return Inertia::render('Responsibilities/Index', [
            'responsibilities' => $responsibilities,
            'patients' => $patients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $staff = User::where('status', 'active')->get();
        $departments = Department::all();
        $wards = Ward::all();
        
        return Inertia::render('Responsibilities/Create', [
            'staff' => $staff,
            'departments' => $departments,
            'wards' => $wards,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:users,id',
            'responsibility_type' => 'required|string',
            'description' => 'required|string',
            'department_id' => 'nullable|exists:departments,id',
            'ward_id' => 'nullable|exists:wards,id',
            'patient_id' => 'nullable|string',
            'status' => 'nullable|in:active,inactive,pending,completed,on-hold',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Responsibility::create($validated);

        return redirect()->route('responsibilities.index')->with('success', 'Responsibility assigned successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Responsibility $responsibility)
    {
        $responsibility->load('staff', 'department', 'ward');
        
        return Inertia::render('Responsibilities/Show', [
            'responsibility' => $responsibility,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Responsibility $responsibility)
    {
        $staff = User::where('status', 'active')->get();
        $departments = Department::all();
        $wards = Ward::all();
        
        return Inertia::render('Responsibilities/Edit', [
            'responsibility' => $responsibility,
            'staff' => $staff,
            'departments' => $departments,
            'wards' => $wards,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Responsibility $responsibility)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:users,id',
            'department_id' => 'nullable|exists:departments,id',
            'ward_id' => 'nullable|exists:wards,id',
            'patient_id' => 'nullable|exists:users,id',
            'responsibility_type' => 'required|string',
            'description' => 'required|string',
            'status' => 'nullable|in:active,inactive,completed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $responsibility->update($validated);

        return redirect()->route('responsibilities.index')->with('success', 'Responsibility updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Responsibility $responsibility)
    {
        $responsibility->delete();

        return redirect()->route('responsibilities.index')->with('success', 'Responsibility deleted successfully.');
    }
}
