<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\StaffRoleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ResponsibilityController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\BedController;
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
    $totalSupervisors = \App\Models\User::where('staff_role_id', 2)->count();

    $staffByRole = \App\Models\User::with('staffRole')
        ->whereNotNull('staff_role_id')
        ->get()
        ->groupBy('staffRole.name')
        ->map(fn($users) => $users->count());

    $wardsData = \App\Models\Ward::select('allocationid', 'wardName', 'wardNumber', 'capacity')
        ->get()
        ->map(function ($ward) {
            $totalBeds = \App\Models\Bed::where('wardNumber', $ward->wardNumber)->count();
            $occupiedBeds = \App\Models\Bed::where('wardNumber', $ward->wardNumber)
                ->where('status', 'Occupied')
                ->count();

            return [
                'name' => $ward->wardName,
                'id' => $ward->allocationid,
                'wardNumber' => $ward->wardNumber,
                'totalBeds' => $totalBeds,
                'occupiedBeds' => $occupiedBeds,
                'availableBeds' => $totalBeds - $occupiedBeds,
                'capacity' => $ward->capacity,
                'staffCount' => $occupiedBeds,
            ];
        });

    return Inertia::render('Dashboard', [
        'totalStaff' => $totalStaff,
        'totalDepartments' => $totalDepartments,
        'totalSupervisors' => $totalSupervisors,
        'compliance' => 100,
        'staffByRole' => $staffByRole,
        'supervisors' => $wardsData,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// Groupmates' Original Routes
Route::middleware(['auth', 'meadow.staff'])->group(function () {
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

    Route::resource('staff', StaffController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('wards', WardController::class);
    Route::resource('staff-roles', StaffRoleController::class);
    Route::resource('schedules', ScheduleController::class);
    Route::resource('responsibilities', ResponsibilityController::class);
    Route::resource('patients', PatientController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========== YOUR WARD & BEDS MODULE ==========
Route::middleware(['auth', 'verified'])->group(function () {
    // Ward routes
    Route::get('/my-wards', [WardController::class, 'index'])->name('my-wards.index');
    Route::get('/my-wards/create', [WardController::class, 'create'])->name('my-wards.create');
    Route::post('/my-wards', [WardController::class, 'store'])->name('my-wards.store');
    Route::get('/my-wards/{allocationid}/edit', [WardController::class, 'edit'])->name('my-wards.edit');
    Route::put('/my-wards/{allocationid}', [WardController::class, 'update'])->name('my-wards.update');
    Route::delete('/my-wards/{allocationid}', [WardController::class, 'destroy'])->name('my-wards.destroy');

    // Bed routes
    Route::get('/my-wards/{wardNumber}/beds', [BedController::class, 'index'])->name('my-wards.beds');
    Route::get('/my-wards/{wardNumber}/beds/{bedNumber}/assign', [BedController::class, 'showAssignForm'])->name('my-wards.beds.assign.form');
    Route::post('/my-wards/{wardNumber}/beds/{bedNumber}/assign', [BedController::class, 'assignPatient'])->name('my-wards.beds.assign');
    Route::post('/my-wards/{wardNumber}/beds/{bedNumber}/vacate', [BedController::class, 'vacateBed'])->name('my-wards.beds.vacate');
});
require __DIR__ . '/auth.php';