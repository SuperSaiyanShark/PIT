<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\StaffRoleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ResponsibilityController;
use App\Http\Controllers\PatientController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'meadow.staff'])->group(function () {
    // Staff Management Routes - Define specific routes BEFORE resource route
    Route::get('/staff/by-role/{role}', [StaffController::class, 'byRole'])->name('staff.byRole');
    Route::get('/staff/by-department/{departmentId}', [StaffController::class, 'byDepartment'])->name('staff.byDepartment');
    Route::get('/staff/by-ward/{wardId}', [StaffController::class, 'byWard'])->name('staff.byWard');
    Route::get('/staff/search', [StaffController::class, 'search'])->name('staff.search');
    Route::get('/staff-statistics', [StaffController::class, 'statistics'])->name('staff.statistics');
    Route::post('/staff/{staff}/assign-ward', [StaffController::class, 'assignWard'])->name('staff.assignWard');
    Route::post('/staff/{staff}/assign-department', [StaffController::class, 'assignDepartment'])->name('staff.assignDepartment');
    Route::post('/staff/{staff}/update-status', [StaffController::class, 'updateStatus'])->name('staff.updateStatus');
    Route::get('/staff/{staff}/schedule', [StaffController::class, 'schedule'])->name('staff.schedule');
    Route::get('/staff/{staff}/responsibilities', [StaffController::class, 'responsibilities'])->name('staff.responsibilities');
    
    // Staff Management - Restricted to @meadow.com users only
    Route::resource('staff', StaffController::class);
    
    // Department Management
    Route::resource('departments', DepartmentController::class);
    
    // Ward Management
    Route::resource('wards', WardController::class);
    
    // Staff Role Management
    Route::resource('staff-roles', StaffRoleController::class);
    
    // Schedule Management
    Route::resource('schedules', ScheduleController::class);
    
    // Responsibility Management
    Route::resource('responsibilities', ResponsibilityController::class);
    

    // ── Patient Management (Module 1) ─────────────────────────────
    Route::get('/patients',                    [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/create',             [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients',                   [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{patient}',          [PatientController::class, 'show'])->name('patients.show');
    Route::get('/patients/{patient}/edit',     [PatientController::class, 'edit'])->name('patients.edit');
    Route::patch('/patients/{patient}',        [PatientController::class, 'update'])->name('patients.update');
    Route::post('/patients/{patient}/medical-records', [PatientController::class, 'storeMedicalRecord'])->name('patients.medical-records.store');
    Route::post('/patients/{patient}/admit',   [PatientController::class, 'admit'])->name('patients.admit');
    Route::post('/patients/{patient}/discharge',[PatientController::class, 'discharge'])->name('patients.discharge');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


