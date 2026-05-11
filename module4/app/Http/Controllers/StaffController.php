<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = Staff::where('is_active', true)->paginate(10);
        return view('staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff',
            'role' => 'required|in:doctor,nurse,administrator',
            'specialization' => 'nullable|string|max:255',
            'license_number' => 'nullable|string|unique:staff',
            'bio' => 'nullable|string',
        ]);

        Staff::create($validated);

        return redirect()->route('staff.index')
                        ->with('success', 'Staff member added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        return view('staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'role' => 'required|in:doctor,nurse,administrator',
            'specialization' => 'nullable|string|max:255',
            'license_number' => 'nullable|string|unique:staff,license_number,' . $staff->id,
            'bio' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $staff->update($validated);

        return redirect()->route('staff.show', $staff)
                        ->with('success', 'Staff member updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        $staff->update(['is_active' => false]);

        return redirect()->route('staff.index')
                        ->with('success', 'Staff member deactivated successfully!');
    }
}
