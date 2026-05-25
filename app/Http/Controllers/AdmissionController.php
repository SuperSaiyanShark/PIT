<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Patient;
use App\Models\Ward;
use App\Models\Bed;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdmissionController extends Controller
{
    public function index()
    {
        $admissions = Admission::with('patient', 'bed', 'bed.ward', 'staff')
            ->orderBy('admissiondate', 'desc')
            ->get();

        return Inertia::render('Admissions/Index', [
            'admissions' => $admissions,
        ]);
    }

    public function create()
    {
        $patients = Patient::all();
        $beds = Bed::with('ward')->where('status', 'Available')->get();
        $staff = User::where('role', 'nurse')
            ->orWhere('role', 'doctor')
            ->orWhere('role', 'head')
            ->get();

        return Inertia::render('Admissions/Create', [
            'patients' => $patients,
            'beds' => $beds,
            'staff' => $staff,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Patient_no'    => 'required|exists:patient,patient_no',
            'BedID'         => 'required|exists:bed,bedid',
            'Staff_no'      => 'required|exists:users,id',
            'AdmissionDate' => 'required|date',
            'reason'        => 'required|string',
            'notes'         => 'nullable|string',
        ]);

        $admission = new Admission();

        // FIXED: Manually find the next available ID sequence to fix PostgreSQL constraint
        $lastAdmission = Admission::orderBy('admissionid', 'desc')->first();
        $admission->admissionid = $lastAdmission ? ($lastAdmission->admissionid + 1) : 1;

        // Map data fields exactly to your matching database schema casing
        $admission->patient_no    = $validated['Patient_no'];
        $admission->bedid         = $validated['BedID'];
        $admission->Staff_no      = $validated['Staff_no']; 
        $admission->admissiondate = $validated['AdmissionDate'];
        $admission->reason        = $validated['reason'];
        $admission->notes         = $validated['notes'];
        $admission->save();

        return redirect(route('admissions.index'))->with('success', 'Patient admitted successfully!');
    }

    public function show(Admission $admission)
    {
        $admission->load('patient', 'bed', 'staff');

        return Inertia::render('Admissions/Show', [
            'admission' => $admission,
        ]);
    }

    public function edit(Admission $admission)
    {
        $admission->load('patient', 'bed', 'staff');
        $patients = Patient::all();
        $beds = Bed::with('ward')->get();
        $staff = User::where('role', 'nurse')
            ->orWhere('role', 'doctor')
            ->orWhere('role', 'head')
            ->get();

        return Inertia::render('Admissions/Edit', [
            'admission' => $admission,
            'patients'  => $patients,
            'beds'      => $beds,
            'staff'     => $staff,
        ]);
    }

    public function update(Request $request, Admission $admission)
    {
        $validated = $request->validate([
            'Patient_no'    => 'required|exists:patient,patient_no',
            'BedID'         => 'required|exists:bed,bedid',
            'Staff_no'      => 'required|exists:users,id',
            'AdmissionDate' => 'required|date',
            'DischargeDate' => 'nullable|date',
            'reason'        => 'required|string',
            'notes'         => 'nullable|string',
        ]);

        // Map properties using exact schema matching
        $admission->patient_no    = $validated['Patient_no'];
        $admission->bedid         = $validated['BedID'];
        $admission->Staff_no      = $validated['Staff_no']; 
        $admission->admissiondate = $validated['AdmissionDate'];
        $admission->dischargedate = $validated['DischargeDate'] ?? null;
        $admission->reason        = $validated['reason'];
        $admission->notes         = $validated['notes'];
        $admission->save();

        return redirect(route('admissions.index'))->with('success', 'Admission updated successfully!');
    }

    public function destroy(Admission $admission)
    {
        $admission->delete();
        return redirect(route('admissions.index'))->with('success', 'Admission deleted successfully!');
    }

    public function discharge(Request $request, Admission $admission)
    {
        $validated = $request->validate([
            'DischargeDate' => 'required|date',
        ]);

        $admission->dischargedate = $validated['DischargeDate'];
        $admission->save();
        
        return redirect(route('admissions.index'))->with('success', 'Patient discharged successfully!');
    }
}