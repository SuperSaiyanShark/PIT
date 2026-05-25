<?php

namespace Modules\Module3\app\Http\Controllers;

use Modules\Module3\app\Models\StaffRole;
use Illuminate\Http\Request;

class StaffRoleController extends Controller
{
    public function index()
    {
        $roles = StaffRole::with('staff')->get();
        
        // CHANGED: Use view() pointing to views/staff-roles/index.blade.php
        return view('module3::staff-roles.index', [
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        // CHANGED: Use view() pointing to views/staff-roles/create.blade.php
        return view('module3::staff-roles.create');
    }

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

    public function show(StaffRole $role)
    {
        $role->load('staff');
        
        // CHANGED: Use view() pointing to views/staff-roles/show.blade.php
        return view('module3::staff-roles.show', [
            'role' => $role,
        ]);
    }

    public function edit(StaffRole $role)
    {
        // CHANGED: Use view() pointing to views/staff-roles/edit.blade.php
        return view('module3::staff-roles.edit', [
            'role' => $role,
        ]);
    }

    public function update(Request $request, StaffRole $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:staff_roles,name,' . $role->id,
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $role->update($validated);

        return redirect()->route('staff-roles.index')->with('success', 'Staff role updated successfully.');
    }

    public function destroy(StaffRole $role)
    {
        $role->delete();

        return redirect()->route('staff-roles.index')->with('success', 'Staff role deleted successfully.');
    }
}