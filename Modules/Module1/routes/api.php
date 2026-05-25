<?php

use Illuminate\Support\Facades\Route;
use Modules\Module1\app\Http\Controllers\Module1Controller;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('module1s', Module1Controller::class)->names('module1');
});
