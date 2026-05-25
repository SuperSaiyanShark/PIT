<?php

use Modules\Module4\app\Http\Controllers\ProfileController;
use Modules\Module4\app\Http\Controllers\AppointmentController;
use Modules\Module4\app\Http\Controllers\TreatmentController;
use Modules\Module4\app\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

// Updated Route: Tells Inertia to find and compile the React asset nested in Module 4
Route::get('/dashboard', function () {
    return Inertia::render('Module4::Dashboard'); 
})->middleware(['auth', 'verified'])->name('module4.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Appointment, Treatment, and Staff resource routing
Route::middleware('auth')->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/choose-type', [AppointmentController::class, 'choosePatientType'])->name('appointments.choose-patient-type');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::patch('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::get('/treatments/recent', [AppointmentController::class, 'recent'])->name('appointments.recent');
    
    Route::resource('treatments', TreatmentController::class);
    Route::resource('staff', StaffController::class);

    // Diagnostics Panel Enpoints
    Route::prefix('diagnostics')->group(function () {
        Route::get('/treatment-count', function (Request $request) {
            $userId = $request->query('user_id', auth()->id());
            $result = DB::select("SELECT get_patient_treatment_count(?) AS total", [$userId]);
            return response()->json(['value' => $result[0]->total ?? 0]);
        })->name('diagnostics.treatment-count');

        Route::get('/daily-appointments', function (Request $request) {
            $userId = $request->query('user_id', auth()->id());
            $date = $request->query('date', now()->toDateString());
            $result = DB::select("SELECT get_patient_daily_appointment_count(?, ?) AS total", [$userId, $date]);
            return response()->json(['value' => $result[0]->total ?? 0]);
        })->name('diagnostics.daily-appointments');

        Route::get('/check-conflict', function (Request $request) {
            $userId = $request->query('user_id', auth()->id());
            $date = $request->query('date', now()->toDateString());
            $time = $request->query('time', '10:00:00');
            $result = DB::select("SELECT has_treatment_time_conflict(?, ?, ?) AS conflict", [$userId, $date, $time]);
            return response()->json(['value' => $result[0]->conflict ? 'Conflict Detected ⚠️' : 'Time Slot Clear ']);
        })->name('diagnostics.check-conflict');
    });
});