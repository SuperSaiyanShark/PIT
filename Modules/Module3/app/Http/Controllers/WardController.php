<?php

namespace Modules\Module3\app\Http\Controllers;

use Modules\Module3\app\Models\Ward;
use Modules\Module3\app\Models\Bed;
use Modules\Module3\app\Models\User;
use Modules\Module3\app\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalStaff = User::where('staff_type', '!=', null)->count();
        $totalDepartments = Department::count();
        $totalSupervisors = User::where('staff_role_id', 2)->count();

        $staffByRole = User::with('staffRole')
            ->whereNotNull('staff_role_id')
            ->get()
            ->groupBy('staffRole.name')
            ->map(fn($users) => $users->count());

        $wardsData = Ward::select('allocationid', 'wardName', 'wardNumber', 'capacity')
            ->get()
            ->map(function ($ward) {
                $totalBeds = Bed::where('wardNumber', $ward->wardNumber)->count();
                $occupiedBeds = Bed::where('wardNumber', $ward->wardNumber)
                    ->where('status', 'Occupied')
                    ->count();

                return [
                    'name' => $ward->wardName,
                    'id' => $ward->allocationid,
                    'wardNumber' => $ward->wardNumber,
                    'totalBeds' => $totalBeds,
                    'occupiedBeds' => $occupiedBeds,
                    'availableBeds' => $totalBeds - $occupiedBeds,
                ];
            });

        return Inertia::render('Module3/WardManagement/Index', [
            'wards' => $wardsData,
            'totalStaff' => $totalStaff,
            'totalDepartments' => $totalDepartments,
            'totalSupervisors' => $totalSupervisors,
            'staffByRole' => $staffByRole,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Module3/WardManagement/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wardName' => 'required|string|max:255',
            'wardNumber' => 'required|string|unique:wards',
            'capacity' => 'required|integer|min:1',
        ]);

        Ward::create($validated);

        return redirect()->route('my-wards.index')->with('success', 'Ward created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ward $ward)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ward = Ward::findOrFail($id);

        return Inertia::render('Module3/WardManagement/Edit', [
            'ward' => $ward,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $ward = Ward::findOrFail($id);

        $validated = $request->validate([
            'wardName' => 'required|string|max:255',
            'wardNumber' => 'required|string|unique:wards,wardNumber,' . $ward->id,
            'capacity' => 'required|integer|min:1',
        ]);

        $ward->update($validated);

        return redirect()->route('my-wards.index')->with('success', 'Ward updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ward = Ward::findOrFail($id);
        $ward->delete();

        return redirect()->route('my-wards.index')->with('success', 'Ward deleted successfully.');
    }
}