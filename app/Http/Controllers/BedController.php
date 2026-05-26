<?php

namespace App\Http\Controllers;

use App\Models\Bed;
use App\Models\Ward;
use Illuminate\Http\Request;

class BedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beds = Bed::with('ward')->paginate(15);
        return view('beds.index', compact('beds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wards = Ward::all();
        return view('beds.create', compact('wards'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wardid' => 'required|exists:wards,id',
            'bednumber' => 'required|string|unique:bed,bednumber',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        Bed::create($validated);

        return redirect()->route('beds.index')->with('success', 'Bed created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bed $bed)
    {
        $bed->load('ward');
        return view('beds.show', compact('bed'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bed $bed)
    {
        $wards = Ward::all();
        return view('beds.edit', compact('bed', 'wards'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bed $bed)
    {
        $validated = $request->validate([
            'wardid' => 'required|exists:wards,id',
            'bednumber' => 'required|string|unique:bed,bednumber,' . $bed->bedid . ',bedid',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        $bed->update($validated);

        return redirect()->route('beds.index')->with('success', 'Bed updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bed $bed)
    {
        $bed->delete();
        return redirect()->route('beds.index')->with('success', 'Bed deleted successfully.');
    }
}
