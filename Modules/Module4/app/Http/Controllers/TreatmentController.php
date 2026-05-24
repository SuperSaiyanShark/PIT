<?php

namespace Modules\Module4\app\Http\Controllers;

use Modules\Module4\app\Models\Treatment;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $treatments = auth()->user()->treatments()->latest()->paginate(10);
        return view('module4::treatments.index', compact('treatments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('module4::treatments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'treatment_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'treatment_date' => 'required|date',
            'treatment_time' => 'nullable|date_format:H:i',
            'appointment_id' => 'nullable|exists:appointments,id',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'scheduled';

        $treatment = Treatment::create($validated);

        return redirect()->route('module4.treatments.show', $treatment)
                        ->with('success', 'Treatment recorded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Treatment $treatment)
    {
        $this->authorize('view', $treatment);
        return view('module4::treatments.show', compact('treatment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Treatment $treatment)
    {
        $this->authorize('update', $treatment);
        return view('module4::treatments.edit', compact('treatment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Treatment $treatment)
    {
        $this->authorize('update', $treatment);

        $validated = $request->validate([
            'treatment_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'treatment_date' => 'required|date',
            'treatment_time' => 'nullable|date_format:H:i',
            'status' => 'required|in:scheduled,in-progress,completed',
            'notes' => 'nullable|string',
        ]);

        $treatment->update($validated);

        return redirect()->route('module4.treatments.show', $treatment)
                        ->with('success', 'Treatment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Treatment $treatment)
    {
        $this->authorize('delete', $treatment);
        $treatment->delete();

        return redirect()->route('module4.treatments.index')
                        ->with('success', 'Treatment deleted successfully!');
    }
}
