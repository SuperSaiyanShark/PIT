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
    $totalStaff = \App\Models\User::where('staff_type', '!=', null)->count();
    $totalDepartments = \App\Models\Department::count();
    $totalPatients = \App\Models\Patient::count();
    $totalWards = \App\Models\Ward::count();
    
    return Inertia::render('Dashboard', [
        'totalStaff' => $totalStaff,
        'totalDepartments' => $totalDepartments,
        'totalPatients' => $totalPatients,
        'totalWards' => $totalWards,
    ]);
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
    
    // Patient Management - Defined in Module1 routes, commenting out to avoid conflicts
    // Route::resource('patients', PatientController::class);
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // =========================================================================
    // MODULE 1 DASHBOARD - STAFF & PATIENT MANAGEMENT
    // =========================================================================
    Route::get('/module1-dashboard', function () {
        return view('module1-dashboard', [
            'totalStaff' => \App\Models\User::where('staff_type', '!=', null)->count(),
            'totalPatients' => \App\Models\Patient::count() ?? 0,
            'totalDepartments' => \App\Models\Department::count(),
            'totalWards' => \App\Models\Ward::count(),
        ]);
    })->name('module1.dashboard');

    // =========================================================================
    // MODULE 4 WORKSPACE PASS-THROUGH ROUTE FOR ZIGGY
    // =========================================================================
    Route::get('/appointments-dashboard', function () {
        return Inertia::render('Module4::Dashboard');
    })->name('module4.dashboard');

});

require __DIR__.'/auth.php';