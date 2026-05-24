<?php

use Illuminate\Support\Facades\Route;
use Modules\ProjectB\Http\Controllers\ProjectBController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('projectbs', ProjectBController::class)->names('projectb');
});
