<?php

namespace Modules\Module4\app\Http\Controllers;

use Modules\Module4\app\Models\Appointment;
use Illuminate\Http\Request;
use Inertia\Inertia; // Added to handle React template handshakes

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with('patient')->get();

        // Converted from view() to Inertia::render() matching your module's folder system
        return Inertia::render('Module4::Appointments/Index', [
            'appointments' => $appointments
        ]);
    }

    /**
     * Show the patient type selection page.
     */
    public function choosePatientType()
    {
        return Inertia::render('Module4::Appointments/ChoosePatientType');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Module4::Appointments/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|date_format:H:i',
            'patient_type' => 'required|in:inpatient,outpatient',
            'reason_for_visit' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'pending';

        $appointment = Appointment::create($validated);

        return redirect()->route('module4.appointments.show', $appointment->id)
                        ->with('success', 'Appointment scheduled successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        // OPTION A: Bypassed/Removed policy validation layer to prevent 403 blocks
        $appointment->load('patient');

        return Inertia::render('Module4::Appointments/Show', [
            'appointment' => $appointment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        // OPTION A: Bypassed/Removed policy validation layer to prevent 403 blocks
        return Inertia::render('Module4::Appointments/Edit', [
            'appointment' => $appointment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        // OPTION A: Bypassed/Removed policy validation layer to prevent 403 blocks
        $validated = $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'patient_type' => 'required|in:inpatient,outpatient',
            'reason_for_visit' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('module4.appointments.show', $appointment->id)
                        ->with('success', 'Appointment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        // OPTION A: Bypassed/Removed policy validation layer to prevent 403 blocks
        $appointment->delete();

        return redirect()->route('module4.appointments.index')
                        ->with('success', 'Appointment cancelled successfully!');
    }

    /**
     * Display recent treatments/appointments.
     */
    public function recent()
    {
        $appointments = Appointment::with('patient')->latest()->limit(5)->get();
        
        return Inertia::render('Module4::Appointments/Recent', [
            'appointments' => $appointments
        ]);
    }
}