<?php

namespace Modules\Module3\app\Http\Controllers;

use Modules\Module3\app\Models\Schedule;
use Modules\Module3\app\Models\User;
use Modules\Module3\app\Models\Department;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('staff')->get();
        
        // FIXED: Change Inertia::render to traditional blade views
        return view('module3::schedules.index', [
            'schedules' => $schedules,
        ]);
    }

    public function create()
    {
        $staff = User::where('status', 'active')->get();
        $departments = Department::all();
        
        // FIXED: Change Inertia::render to traditional blade views
        return view('module3::schedules.create', [
            'staff' => $staff,
            'departments' => $departments,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'shift_type' => 'nullable|string',
            'status' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Schedule::create($validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function show(Schedule $schedule)
    {
        $schedule->load('staff');
        
        // FIXED: Change Inertia::render to traditional blade views
        return view('module3::schedules.show', [
            'schedule' => $schedule,
        ]);
    }

    public function edit(Schedule $schedule)
    {
        $staff = User::where('status', 'active')->get();
        $departments = Department::all();
        
        // FIXED: Change Inertia::render to traditional blade views
        return view('module3::schedules.edit', [
            'schedule' => $schedule,
            'staff' => $staff,
            'departments' => $departments,
        ]);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'shift_type' => 'nullable|string',
            'status' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
