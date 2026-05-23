<?php

namespace App\Http\Controllers;

use App\Models\StaffRole;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaffRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffRoles = StaffRole::with('staff')->get();
        
        return Inertia::render('StaffRoles/Index', [
            'staffRoles' => $staffRoles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('StaffRoles/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:staff_roles',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        StaffRole::create($validated);

        return redirect()->route('staff-roles.index')->with('success', 'Staff role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StaffRole $staffRole)
    {
        $staffRole->load('staff');
        
        return Inertia::render('StaffRoles/Show', [
            'staffRole' => $staffRole,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StaffRole $staffRole)
    {
        return Inertia::render('StaffRoles/Edit', [
            'staffRole' => $staffRole,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StaffRole $staffRole)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:staff_roles,name,' . $staffRole->id,
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $staffRole->update($validated);

        return redirect()->route('staff-roles.index')->with('success', 'Staff role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StaffRole $staffRole)
    {
        $staffRole->delete();

        return redirect()->route('staff-roles.index')->with('success', 'Staff role deleted successfully.');
    }
}
