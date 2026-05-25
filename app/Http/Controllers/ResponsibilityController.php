<?php

namespace App\Http\Controllers;

use App\Models\Responsibility;
use App\Models\User;
use App\Models\Department;
use App\Models\Ward;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResponsibilityController extends Controller
{
    public function index()
    {
        $responsibilities = Responsibility::with('staff', 'department', 'ward')->get();
        
        return Inertia::render('Responsibilities/Index', [
            'responsibilities' => $responsibilities,
        ]);
    }

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id'               => 'required|exists:users,id',
            'responsibility_type'    => 'nullable|string',
            'description'            => 'required|string',
            'department_id'          => 'nullable|exists:departments,id',
            'ward_id'                => 'nullable|exists:wards,id',
            'shift_type'             => 'nullable|string',
            'staff_role_id'          => 'nullable|exists:staff_roles,id',
            'patient_id'             => 'nullable|string',
            'status'                 => 'nullable|in:active,inactive,pending,completed,on-hold',
            'start_date'             => 'nullable|date',
            'end_date'               => 'nullable|date|after_or_equal:start_date',
            'prevent_double_booking' => 'boolean',
        ]);

        if (!empty($validated['prevent_double_booking'])) {
            $conflict = Responsibility::where('staff_id', $validated['staff_id'])
                ->where('start_date', $validated['start_date'])
                ->where('shift_type', $validated['shift_type'])
                ->where('status', 'active')
                ->exists();

            if ($conflict) {
                return back()->withErrors([
                    'start_date' => 'This staff member is already allocated on this date and shift.'
                ]);
            }
        }

        Responsibility::create($validated);

        return redirect()->route('responsibilities.index')
            ->with('success', 'Responsibility assigned successfully.');
    }

    public function show(Responsibility $responsibility)
    {
        $responsibility->load('staff', 'department', 'ward');
        
        return Inertia::render('Responsibilities/Show', [
            'responsibility' => $responsibility,
        ]);
    }

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

    public function update(Request $request, Responsibility $responsibility)
    {
        $validated = $request->validate([
            'staff_id'            => 'required|exists:users,id',
            'department_id'       => 'nullable|exists:departments,id',
            'ward_id'             => 'nullable|exists:wards,id',
            'patient_id'          => 'nullable|string',
            'responsibility_type' => 'nullable|string',
            'description'         => 'required|string',
            'shift_type'          => 'nullable|string',
            'staff_role_id'       => 'nullable|exists:staff_roles,id',
            'status'              => 'nullable|in:active,inactive,pending,completed,on-hold',
            'start_date'          => 'nullable|date',
            'end_date'            => 'nullable|date|after_or_equal:start_date',
        ]);

        $responsibility->update($validated);

        return redirect()->route('responsibilities.index')
            ->with('success', 'Responsibility updated successfully.');
    }

    public function destroy(Responsibility $responsibility)
    {
        $responsibility->delete();

        return redirect()->route('responsibilities.index')
            ->with('success', 'Responsibility deleted successfully.');
    }
}