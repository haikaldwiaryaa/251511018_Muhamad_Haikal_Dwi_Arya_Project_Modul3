<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('activities.index');
});

// Menggantikan Route::get sebelumnya dengan Resource Route
Route::get('activities/trash', [ActivityController::class, 'trash'])->name('activities.trash');
Route::patch('activities/{activity}/restore', [ActivityController::class, 'restore'])->name('activities.restore');

Route::resource('activities', ActivityController::class);
Route::patch('activities/{activity}/publish', [ActivityController::class, 'publish'])->name('activities.publish');
Route::patch('activities/{activity}/complete', [ActivityController::class, 'complete'])->name('activities.complete');
