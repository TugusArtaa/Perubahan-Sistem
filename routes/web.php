<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ChangeController;

// Rute untuk resource applications
Route::resource('applications', ApplicationController::class);

// Rute untuk changes terkait applications
Route::get('applications/{application}/changes/create', [ChangeController::class, 'create'])->name('changes.create');
Route::post('applications/{application}/changes', [ChangeController::class, 'store'])->name('changes.store');
Route::get('changes/{change}/edit', [ChangeController::class, 'edit'])->name('changes.edit');
Route::put('changes/{change}', [ChangeController::class, 'update'])->name('changes.update');
Route::delete('applications/{application}/changes/{change}', [ChangeController::class, 'destroy'])->name('changes.destroy');

// Rute untuk menampilkan semua perubahan
Route::get('changes', [ChangeController::class, 'index'])->name('changes.index');

// Rute tambahan dari route.php
Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
Route::get('/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
Route::get('/applications/{application}/changes', [ChangeController::class, 'index']);
Route::get('/applications/{application}/changes/{change}', [ChangeController::class, 'show']);