<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use App\Models\Bed;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class BedController extends Controller
{
    public function index($wardNumber)
    {
        $ward = Ward::where('wardNumber', $wardNumber)->firstOrFail();
        $beds = Bed::where('wardNumber', $wardNumber)
            ->orderBy('bedNumber', 'asc')
            ->get();

        return Inertia::render('WardManagement/Beds', [
            'ward' => $ward,
            'beds' => $beds
        ]);
    }

    public function showAssignForm($wardNumber, $bedNumber)
    {
        $ward = Ward::where('wardNumber', $wardNumber)->firstOrFail();
        $bed = Bed::where('wardNumber', $wardNumber)
            ->where('bedNumber', $bedNumber)
            ->firstOrFail();

        return Inertia::render('WardManagement/AssignBed', [
            'ward' => $ward,
            'bed' => $bed
        ]);
    }

    public function assignPatient(Request $request, $wardNumber, $bedNumber)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
        ]);

        // Call stored procedure sp_assign_bed
        DB::statement('CALL sp_assign_bed(?, ?)', [$bedNumber, $wardNumber]);

        // Update patient name
        DB::table('beds')
            ->where('bedNumber', $bedNumber)
            ->where('wardNumber', $wardNumber)
            ->update(['patient_name' => $request->patient_name]);

        return redirect()->route('my-wards.beds', $wardNumber)
            ->with('success', 'Patient assigned to bed ' . $bedNumber . ' successfully');
    }

    public function vacateBed($wardNumber, $bedNumber)
    {
        // Call stored procedure sp_release_bed
        DB::statement('CALL sp_release_bed(?, ?)', [$bedNumber, $wardNumber]);

        return redirect()->route('my-wards.beds', $wardNumber)
            ->with('success', 'Bed ' . $bedNumber . ' vacated successfully');
    }

    public function wardSummary($wardNumber)
    {
        // Call stored procedure sp_ward_summary
        DB::statement('CALL sp_ward_summary(?)', [$wardNumber]);

        // Return summary data
        $totalBeds = Bed::where('wardNumber', $wardNumber)->count();
        $occupiedBeds = Bed::where('wardNumber', $wardNumber)
            ->where('status', 'Occupied')
            ->count();
        $availableBeds = Bed::where('wardNumber', $wardNumber)
            ->where('status', 'Available')
            ->count();

        $ward = Ward::where('wardNumber', $wardNumber)->first();

        return response()->json([
            'ward_name' => $ward->wardName,
            'total_beds' => $totalBeds,
            'occupied_beds' => $occupiedBeds,
            'available_beds' => $availableBeds,
            'capacity' => $ward->capacity,
        ]);
    }
}