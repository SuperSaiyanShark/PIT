<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedule::with('staff')->get();
        
        // FIXED: Pointed directly to the Module3 view subfolder
        return Inertia::render('Module3/Schedules/Index', [
            'schedules' => $schedules,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $staff = User::where('status', 'active')->get();
        
        // FIXED: Pointed directly to the Module3 view subfolder
        return Inertia::render('Module3/Schedules/Create', [
            'staff' => $staff,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Adjusted validation rules to match input types from your Create.jsx
        $validated = $request->validate([
            'staff_id'   => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'shift_type' => 'nullable|in:morning,afternoon,night',
            'status'     => 'nullable|in:active,inactive,pending',
            'notes'      => 'nullable|string',
        ]);

        Schedule::create($validated);

        // FIXED: Redirects to index list page instead of stuck on the form
        return redirect()->route('schedules.index')->with('success', 'Schedule added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        $schedule->load('staff');
        
        // FIXED: Pointed directly to the Module3 view subfolder
        return Inertia::render('Module3/Schedules/Show', [
            'schedule' => $schedule,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        $staff = User::where('status', 'active')->get();
        
        // FIXED: Pointed directly to the Module3 view subfolder
        return Inertia::render('Module3/Schedules/Edit', [
            'schedule' => $schedule,
            'staff' => $staff,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'shift_type' => 'required|in:morning,afternoon,night',
            'status' => 'nullable|in:active,inactive,pending',
            'notes' => 'nullable|string',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}