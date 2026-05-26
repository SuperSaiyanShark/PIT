<?php

use Modules\Module3\app\Http\Controllers\WardController;
use Modules\Module3\app\Http\Controllers\BedController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])
    ->prefix('module3')
    ->name('module3.')
    ->group(function () {

        Route::get('/dashboard', function () {
            $wards = \App\Models\Ward::with('beds')->get();
            return view('module3::wards.index', compact('wards'));
        })->name('dashboard');

        Route::get('/my-wards', [WardController::class, 'index'])->name('my-wards.index');
        Route::get('/my-wards/create', [WardController::class, 'create'])->name('my-wards.create');
        Route::post('/my-wards', [WardController::class, 'store'])->name('my-wards.store');
        Route::get('/my-wards/{allocationid}/edit', [WardController::class, 'edit'])->name('my-wards.edit');
        Route::put('/my-wards/{allocationid}', [WardController::class, 'update'])->name('my-wards.update');
        Route::delete('/my-wards/{allocationid}', [WardController::class, 'destroy'])->name('my-wards.destroy');

        Route::get('/my-wards/{wardNumber}/beds', [BedController::class, 'index'])->name('my-wards.beds');
        Route::post('/my-wards/{wardNumber}/beds/{bedNumber}/assign', [BedController::class, 'assignPatient'])->name('my-wards.beds.assign');
        Route::post('/my-wards/{wardNumber}/beds/{bedNumber}/vacate', [BedController::class, 'vacateBed'])->name('my-wards.beds.vacate');
    });