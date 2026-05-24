<?php

namespace Modules\Module4\app\Http\Controllers;

use Modules\Module4\app\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AppointmentController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = auth()->user()->appointments;
        return view('module4::appointments.index', compact('appointments'));
    }

    /**
     * Show the patient type selection page.
     */
    public function choosePatientType()
    {
        return view('module4::appointments.choose-patient-type');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('module4::appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required|date_format:H:i',
            'patient_type' => 'required|in:inpatient,outpatient',
            'reason_for_visit' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        $appointment = Appointment::create($validated);

        return redirect()->route('module4.appointments.show', $appointment)
                        ->with('success', 'Appointment scheduled successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $this->authorize('view', $appointment);
        return view('module4::appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        $this->authorize('update', $appointment);
        return view('module4::appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $validated = $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'patient_type' => 'required|in:inpatient,outpatient',
            'reason_for_visit' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('module4.appointments.show', $appointment)
                        ->with('success', 'Appointment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);
        
        $appointment->delete();

        return redirect()->route('module4.appointments.index')
                        ->with('success', 'Appointment cancelled successfully!');
    }

    /**
     * Display recent treatments/appointments.
     */
    public function recent()
    {
        $appointments = auth()->user()->appointments()->latest()->limit(5)->get();
        return view('module4::appointments.recent', compact('appointments'));
    }
}
