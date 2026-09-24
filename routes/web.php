<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('activities.index');
});

// Menggantikan Route::get sebelumnya dengan Resource Route
Route::resource('activities', ActivityController::class);
