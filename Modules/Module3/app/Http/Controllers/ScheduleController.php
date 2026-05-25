<?php

namespace Modules\Module3\app\Http\Controllers;

use Modules\Module3\app\Models\Schedule;
use Modules\Module3\app\Models\User;
use Modules\Module3\app\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('staff')->get();
        
        // Forces lookup directly to: ./Pages/Module3/Schedules/Index.jsx
        return Inertia::render('Module3::Schedules/Index', [
            'schedules' => $schedules,
        ]);
    }

    public function create()
    {
        $staff = User::where('status', 'active')->get();
        $departments = Department::all();
        
        // Forces lookup directly to: ./Pages/Module3/Schedules/Create.jsx
        return Inertia::render('Module3::Schedules/Create', [
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
        
        // Forces lookup directly to: ./Pages/Module3/Schedules/Show.jsx
        return Inertia::render('Module3::Schedules/Show', [
            'schedule' => $schedule,
        ]);
    }

    public function edit(Schedule $schedule)
    {
        $staff = User::where('status', 'active')->get();
        $departments = Department::all();
        
        // Forces lookup directly to: ./Pages/Module3/Schedules/Edit.jsx
        return Inertia::render('Module3::Schedules/Edit', [
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