<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use App\Models\Bed;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WardController extends Controller
{
    public function index()
    {
        $wards = Ward::withCount('beds')
            ->withCount([
                'beds as occupied_beds_count' => function ($query) {
                    $query->where('status', 'Occupied');
                }
            ])
            ->get();

        return Inertia::render('WardManagement/Index', [
            'wards' => $wards
        ]);
    }

    public function create()
    {
        return Inertia::render('WardManagement/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'allocationid' => 'required|unique:wards',
            'wardNumber' => 'required|unique:wards',
            'wardName' => 'required',
            'capacity' => 'required|integer|min:1',
        ]);

        $ward = Ward::create([
            'allocationid' => $request->allocationid,
            'wardNumber' => $request->wardNumber,
            'wardName' => $request->wardName,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'telExtn' => $request->telExtn,
        ]);

        // Create beds automatically using sp_assign_bed procedure logic
        for ($i = 1; $i <= $request->capacity; $i++) {
            Bed::create([
                'bedNumber' => 'B-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'wardNumber' => $ward->wardNumber, // This should be the new ward's number
                'status' => 'Available',
                'is_occupied' => false,
            ]);
        }

        return redirect()->route('my-wards.index')->with('success', 'Ward created successfully!');
    }

    public function edit($allocationid)
    {
        $ward = Ward::findOrFail($allocationid);
        return Inertia::render('WardManagement/Edit', [
            'ward' => $ward
        ]);
    }

    public function update(Request $request, $allocationid)
    {
        $ward = Ward::findOrFail($allocationid);

        $request->validate([
            'wardName' => 'required',
            'capacity' => 'required|integer|min:1',
        ]);

        $ward->update([
            'wardName' => $request->wardName,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'telExtn' => $request->telExtn,
        ]);

        return redirect()->route('my-wards.index')->with('success', 'Ward updated successfully!');
    }

    public function destroy($allocationid)
    {
        $ward = Ward::findOrFail($allocationid);
        $ward->delete();

        return redirect()->route('my-wards.index')->with('success', 'Ward deleted successfully!');
    }
}