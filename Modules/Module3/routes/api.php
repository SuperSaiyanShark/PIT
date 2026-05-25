<?php

use Illuminate\Support\Facades\Route;
use Modules\Module3\Http\Controllers\Module3Controller;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('module3s', Module3Controller::class)->names('module3');
});
