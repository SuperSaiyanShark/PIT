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
    $totalSupervisors = \App\Models\User::where('staff_role_id', 2)->count(); // Assuming 2 is Supervisor role
    
    // Get staff by role
    $staffByRole = \App\Models\User::with('staffRole')
        ->whereNotNull('staff_role_id')
        ->get()
        ->groupBy('staffRole.name')
        ->map(fn($users) => $users->count());
    
    // Get supervisors with their staff count
    $supervisors = \App\Models\Ward::with('head')
        ->whereNotNull('ward_head_id')
        ->get()
        ->groupBy('ward_head_id')
        ->map(function($wards) {
            $headId = $wards->first()->ward_head_id;
            $head = \App\Models\User::find($headId);
            $staffCount = \App\Models\User::where('ward_id', $wards->pluck('id')->toArray())->count();
            
            return [
                'name' => $head?->name ?? 'Unknown',
                'id' => $headId,
                'staffCount' => $staffCount,
            ];
        })
        ->values();
    
    return Inertia::render('Dashboard', [
        'totalStaff' => $totalStaff,
        'totalDepartments' => $totalDepartments,
        'totalSupervisors' => $totalSupervisors,
        'compliance' => 100,
        'staffByRole' => $staffByRole,
        'supervisors' => $supervisors,
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
    
    // Patient Management
    Route::resource('patients', PatientController::class);
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
