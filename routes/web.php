<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ChangeController;
use App\Http\Controllers\DashboardController;

// Protected dashboard route
Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard/changes-data', [DashboardController::class, 'getChangesData'])->middleware(['auth', 'verified'])->name('dashboard.changes.data');

// Protected application routes
Route::middleware(['auth'])->group(function () {
    // Rute untuk resource applications
    Route::resource('applications', ApplicationController::class);
    Route::get('/applications-data', [ApplicationController::class, 'getApplicationsData'])->name('applications.data');
    Route::get('/changes-data', [ChangeController::class, 'getChangesData'])->name('changes.data');

    // Rute untuk katalog aplikasi
    Route::get('applications/{application}/catalog', [ApplicationController::class, 'catalog'])->name('applications.catalog');
    Route::get('applications/{application}/download-pdf', [ApplicationController::class, 'downloadPdf'])->name('applications.downloadPdf');

    // Rute untuk changes terkait applications
    Route::prefix('applications/{application}')->group(function () {
        Route::get('changes/create', [ChangeController::class, 'create'])->name('application.changes.create');
        Route::post('changes', [ChangeController::class, 'store'])->name('application.changes.store');
        Route::get('changes', [ChangeController::class, 'index'])->name('application.changes.index');
        Route::get('changes/{change}', [ChangeController::class, 'show'])->name('application.changes.show');
        Route::delete('changes/{change}', [ChangeController::class, 'destroy'])->name('application.changes.destroy');
    });

    // Rute untuk changes yang tidak terkait dengan applications
    Route::prefix('changes')->group(function () {
        Route::get('/', [ChangeController::class, 'index'])->name('changes.index');
        Route::get('{change}', [ChangeController::class, 'show'])->name('changes.show');
        Route::get('{change}/edit', [ChangeController::class, 'edit'])->name('changes.edit');
        Route::put('{change}', [ChangeController::class, 'update'])->name('changes.update');
        Route::patch('{change}/approve', [ChangeController::class, 'approve'])->name('changes.approve');
        Route::patch('{change}/reject', [ChangeController::class, 'reject'])->name('changes.reject');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Test route for SweetAlert2 styling
Route::get('/test-sweetalert', function () {
    return view('test-sweetalert');
})->name('test.sweetalert');

require __DIR__.'/auth.php';
