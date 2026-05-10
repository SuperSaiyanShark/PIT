<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

/*
|--------------------------------------------------------------------------
| Patient Management Module Routes
| Add these to your existing routes/web.php file
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('patients.index');
});

Route::prefix('patients')->name('patients.')->group(function () {
    Route::get('/',         [PatientController::class, 'index'])->name('index');
    Route::post('/',        [PatientController::class, 'store'])->name('store');
    Route::get('/{patient}', [PatientController::class, 'show'])->name('show');
    Route::put('/{patient}', [PatientController::class, 'update'])->name('update');

    // Medical records
    Route::post('/{patient}/medical-records', [PatientController::class, 'storeMedicalRecord'])->name('medical-records.store');

    // Admission / Discharge
    Route::post('/{patient}/admit',     [PatientController::class, 'storeAdmission'])->name('admit');
    Route::post('/{patient}/discharge', [PatientController::class, 'discharge'])->name('discharge');
});
