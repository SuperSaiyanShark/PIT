<?php

use Modules\Module3\app\Http\Controllers\ProfileController;
use Modules\Module3\app\Http\Controllers\StaffController;
use Modules\Module3\app\Http\Controllers\DepartmentController;
use Modules\Module3\app\Http\Controllers\WardController;
use Modules\Module3\app\Http\Controllers\StaffRoleController;
use Modules\Module3\app\Http\Controllers\ScheduleController;
use Modules\Module3\app\Http\Controllers\ResponsibilityController;
use Modules\Module3\app\Http\Controllers\PatientController;
use Modules\Module3\app\Http\Controllers\BedController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ... (Keep your existing '/', '/dashboard' and 'INERTIA-ONLY' routes as they are) ...

// ==================== NATIVE BLADE GROUP (Module 3 Workspace) ====================
// UPDATED: Added withoutMiddleware to stop Inertia from hijacking these blade views
Route::middleware(['auth', 'verified'])
    ->withoutMiddleware([\App\Http\Middleware\HandleInertiaRequests::class]) 
    ->group(function () {
    
    // Standard CRUD Resources targeting your pure Blade templates
    Route::resource('departments', DepartmentController::class);
    Route::resource('staff-roles', StaffRoleController::class);
    Route::resource('schedules', ScheduleController::class);

    // Ward Workflow URLs
    Route::get('/my-wards', [WardController::class, 'index'])->name('my-wards.index');
    Route::get('/my-wards/create', [WardController::class, 'create'])->name('my-wards.create');
    Route::post('/my-wards', [WardController::class, 'store'])->name('my-wards.store');
    Route::get('/my-wards/{allocationid}/edit', [WardController::class, 'edit'])->name('my-wards.edit');
    Route::put('/my-wards/{allocationid}', [WardController::class, 'update'])->name('my-wards.update');
    Route::delete('/my-wards/{allocationid}', [WardController::class, 'destroy'])->name('my-wards.destroy');

    // Bed Mapping System
    Route::get('/my-wards/{wardNumber}/beds', [BedController::class, 'index'])->name('my-wards.beds');
    Route::get('/my-wards/{wardNumber}/beds/{bedNumber}/assign', [BedController::class, 'showAssignForm'])->name('my-wards.beds.assign.form');
    Route::post('/my-wards/{wardNumber}/beds/{bedNumber}/assign', [BedController::class, 'assignPatient'])->name('my-wards.beds.assign');
    Route::post('/my-wards/{wardNumber}/beds/{bedNumber}/vacate', [BedController::class, 'vacateBed'])->name('my-wards.beds.vacate');
});