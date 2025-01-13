<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ChangeController;
use App\Http\Controllers\DashboardController;

// Rute untuk resource applications
Route::resource('applications', ApplicationController::class);

// Rute untuk katalog aplikasi
Route::get('applications/{application}/catalog', [ApplicationController::class, 'catalog'])->name('applications.catalog');
Route::get('applications/{application}/download-pdf', [ApplicationController::class, 'downloadPdf'])->name('applications.downloadPdf');

// Rute untuk dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Rute untuk changes terkait applications
Route::prefix('applications/{application}')->group(function () {
    Route::get('changes/create', [ChangeController::class, 'create'])->name('changes.create');
    Route::post('changes', [ChangeController::class, 'store'])->name('changes.store');
    Route::get('changes', [ChangeController::class, 'index'])->name('changes.index');
    Route::get('changes/{change}', [ChangeController::class, 'show'])->name('changes.show');
    Route::delete('changes/{change}', [ChangeController::class, 'destroy'])->name('changes.destroy');
});

// Rute untuk changes yang tidak terkait dengan applications
Route::prefix('changes')->group(function () {
    Route::get('/', [ChangeController::class, 'index'])->name('changes.index');
    Route::get('{change}/edit', [ChangeController::class, 'edit'])->name('changes.edit');
    Route::put('{change}', [ChangeController::class, 'update'])->name('changes.update');
});