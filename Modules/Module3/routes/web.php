<?php

use Illuminate\Support\Facades\Route;
use Modules\Module3\Http\Controllers\Module3Controller;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('module3s', Module3Controller::class)->names('module3');
});
