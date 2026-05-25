<?php

use Illuminate\Support\Facades\Route;
use Modules\Module1\Http\Controllers\Module1Controller;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('module1s', Module1Controller::class)->names('module1');
});
