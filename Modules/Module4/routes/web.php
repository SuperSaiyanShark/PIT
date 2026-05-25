<?php

use Modules\Module4\app\Http\Controllers\ProfileController;
use Modules\Module4\app\Http\Controllers\AppointmentController;
use Modules\Module4\app\Http\Controllers\TreatmentController;
use Modules\Module4\app\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('module4::dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Appointment, Treatment, and Staff routes
Route::middleware('auth')->group(function () {
    // View all appointments
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    
    // Choose patient type for new appointment
    Route::get('/appointments/choose-type', [AppointmentController::class, 'choosePatientType'])->name('appointments.choose-patient-type');
    
    // Create new appointment
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    
    // View appointment details
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    
    // Edit appointment
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::patch('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    
    // Cancel/delete appointment
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    
    // View recent treatments
    Route::get('/treatments/recent', [AppointmentController::class, 'recent'])->name('appointments.recent');
    
    // Treatment routes
    Route::resource('treatments', TreatmentController::class);
    
    // Staff routes
    Route::resource('staff', StaffController::class);

    // =========================================================================
    // Module 2 Database Routine Diagnostic Inspector Endpoints
    // =========================================================================
    Route::prefix('diagnostics')->group(function () {
        
        // Call Function 1: Get Total Patient Treatment Records
        Route::get('/treatment-count', function (Request $request) {
            $userId = $request->query('user_id', auth()->id());
            $result = DB::select("SELECT get_patient_treatment_count(?) AS total", [$userId]);
            return response()->json(['value' => $result[0]->total ?? 0]);
        })->name('diagnostics.treatment-count');

        // Call Function 2: Get Daily Scheduled Appointments for Current Profile
        Route::get('/daily-appointments', function (Request $request) {
            $userId = $request->query('user_id', auth()->id());
            $date = $request->query('date', now()->toDateString());
            $result = DB::select("SELECT get_patient_daily_appointment_count(?, ?) AS total", [$userId, $date]);
            return response()->json(['value' => $result[0]->total ?? 0]);
        })->name('diagnostics.daily-appointments');

        // Call Function 3: Run Safety Check to identify overlapping scheduling conflicts
        Route::get('/check-conflict', function (Request $request) {
            $userId = $request->query('user_id', auth()->id());
            $date = $request->query('date', now()->toDateString());
            $time = $request->query('time', '10:00:00');
            $result = DB::select("SELECT has_treatment_time_conflict(?, ?, ?) AS conflict", [$userId, $date, $time]);
            return response()->json(['value' => $result[0]->conflict ? 'Conflict Detected ⚠️' : 'Time Slot Clear ']);
        })->name('diagnostics.check-conflict');
    });
});