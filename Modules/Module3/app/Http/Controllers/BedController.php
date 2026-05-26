<?php

namespace Modules\Module3\app\Http\Controllers;

use App\Models\Ward;
use Modules\Module3\app\Models\Bed;
use Illuminate\Http\Request;

class BedController extends Controller
{
    public function index($wardNumber)
    {
        $ward = Ward::where('wardNumber', $wardNumber)->firstOrFail();
        $beds = Bed::where('wardNumber', $wardNumber)
            ->orderBy('bedNumber', 'asc')
            ->get();

        return view('module3::beds.index', compact('ward', 'beds'));
    }

    public function assignPatient(Request $request, $wardNumber, $bedNumber)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
        ]);

        $bed = Bed::where('wardNumber', $wardNumber)
            ->where('bedNumber', $bedNumber)
            ->firstOrFail();

        $bed->update([
            'status' => 'Occupied',
            'patient_name' => $request->patient_name,
            'is_occupied' => true
        ]);

        return redirect()->route('my-wards.beds', $wardNumber)
            ->with('success', 'Patient assigned to bed ' . $bedNumber);
    }

    public function vacateBed($wardNumber, $bedNumber)
    {
        $bed = Bed::where('wardNumber', $wardNumber)
            ->where('bedNumber', $bedNumber)
            ->firstOrFail();

        $bed->update([
            'status' => 'Available',
            'patient_name' => null,
            'is_occupied' => false
        ]);

        return redirect()->route('my-wards.beds', $wardNumber)
            ->with('success', 'Bed ' . $bedNumber . ' vacated');
    }
}