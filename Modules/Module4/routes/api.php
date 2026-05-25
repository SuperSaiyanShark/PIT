<?php

use Illuminate\Support\Facades\Route;
use Modules\Module4\app\Http\Controllers\TreatmentController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('treatments', TreatmentController::class)->names('module4.treatments');
});
