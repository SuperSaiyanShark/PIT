<?php

namespace Modules\Module3\app\Http\Controllers;

use Modules\Module3\app\Models\Department;
use Modules\Module3\app\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('head', 'staff')->get();
        
        // CHANGED: Use view() pointing to views/departments/index.blade.php
        return view('module3::departments.index', [
            'departments' => $departments,
        ]);
    }

    public function create()
    {
        $heads = User::where('role', 'doctor')->orWhere('role', 'head')->get();
        
        // CHANGED: Use view() pointing to views/departments/create.blade.php
        return view('module3::departments.create', [
            'heads' => $heads,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:departments',
            'description' => 'nullable|string',
            'head_id' => 'nullable|exists:users,id',
            'building' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        $department->load('head', 'wards', 'staff', 'responsibilities');
        
        // CHANGED: Use view() pointing to views/departments/show.blade.php
        return view('module3::departments.show', [
            'department' => $department,
        ]);
    }

    public function edit(Department $department)
    {
        $heads = User::where('role', 'doctor')->orWhere('role', 'head')->get();
        
        // CHANGED: Use view() pointing to views/departments/edit.blade.php
        return view('module3::departments.edit', [
            'department' => $department,
            'heads' => $heads,
        ]);
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:departments,name,' . $department->id,
            'description' => 'nullable|string',
            'head_id' => 'nullable|exists:users,id',
            'building' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}