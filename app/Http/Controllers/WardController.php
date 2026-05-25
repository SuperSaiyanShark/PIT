<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wards = Ward::with('department', 'head', 'staff')->get();
        
        // FIXED: Pointed directly to your Module3/WardManagement view directory
        return Inertia::render('Module3/WardManagement/Index', [
            'wards' => $wards,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        // Get staff with Ward Head role (staff_role_id = 1, which is Ward Head)
        $heads = User::whereHas('staffRole', function ($query) {
            $query->where('name', 'Ward Head');
        })->get();
        
        // FIXED: Pointed directly to your Module3/WardManagement view directory
        return Inertia::render('Module3/WardManagement/Create', [
            'departments' => $departments,
            'heads' => $heads,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'floor' => 'nullable|integer',
            'capacity' => 'nullable|integer|min:1',
            'ward_head_id' => 'nullable|exists:users,id',
        ]);

        Ward::create($validated);

        return redirect()->route('wards.index')->with('success', 'Ward created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ward $ward)
    {
        $ward->load('department', 'head', 'staff', 'responsibilities');
        
        // FIXED: Pointed directly to your Module3/WardManagement view directory
        return Inertia::render('Module3/WardManagement/Show', [
            'ward' => $ward,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ward $ward)
    {
        $departments = Department::all();
        // Get staff with Ward Head role (staff_role_id = 1, which is Ward Head)
        $heads = User::whereHas('staffRole', function ($query) {
            $query->where('name', 'Ward Head');
        })->get();
        
        // FIXED: Pointed directly to your Module3/WardManagement view directory
        return Inertia::render('Module3/WardManagement/Edit', [
            'ward' => $ward,
            'departments' => $departments,
            'heads' => $heads,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ward $ward)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'floor' => 'nullable|integer',
            'capacity' => 'nullable|integer|min:1',
            'ward_head_id' => 'nullable|exists:users,id',
        ]);

        $ward->update($validated);

        return redirect()->route('wards.index')->with('success', 'Ward updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ward $ward)
    {
        $ward->delete();

        return redirect()->route('wards.index')->with('success', 'Ward deleted successfully.');
    }
}