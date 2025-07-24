<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ChangeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserManagementController;

// Protected dashboard route
Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard/changes-data', [DashboardController::class, 'getChangesData'])->middleware(['auth', 'verified'])->name('dashboard.changes.data');

// Protected application routes with permissions
Route::middleware(['auth'])->group(function () {
    // Application management routes (Protected by permissions)
    // Create routes must come before parameterized routes
    Route::middleware(['permission:create-applications'])->group(function () {
        Route::get('applications/create', [ApplicationController::class, 'create'])->name('applications.create');
        Route::post('applications', [ApplicationController::class, 'store'])->name('applications.store');
    });
    
    Route::middleware(['permission:view-applications'])->group(function () {
        Route::get('applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications-data', [ApplicationController::class, 'getApplicationsData'])->name('applications.data');
        Route::get('applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
        Route::get('applications/{application}/catalog', [ApplicationController::class, 'catalog'])->name('applications.catalog');
        Route::get('applications/{application}/download-pdf', [ApplicationController::class, 'downloadPdf'])->name('applications.downloadPdf');
    });
    
    Route::middleware(['permission:edit-applications'])->group(function () {
        Route::get('applications/{application}/edit', [ApplicationController::class, 'edit'])->name('applications.edit');
        Route::put('applications/{application}', [ApplicationController::class, 'update'])->name('applications.update');
    });
    
    Route::middleware(['permission:delete-applications'])->group(function () {
        Route::delete('applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
    });

    // Bulk delete route
    Route::post('applications/bulk-delete', [ApplicationController::class, 'bulkDelete'])->name('applications.bulkDelete');

    // Bulk delete changes route
    Route::post('changes/bulk-delete', [ChangeController::class, 'bulkDelete'])->name('changes.bulkDelete');

    // Change management routes (Protected by permissions)
    Route::middleware(['permission:view-changes'])->group(function () {
        Route::get('/changes-data', [ChangeController::class, 'getChangesData'])->name('changes.data');
        Route::get('changes', [ChangeController::class, 'index'])->name('changes.index');
        Route::get('changes/{change}', [ChangeController::class, 'show'])->name('changes.show');
        Route::get('applications/{application}/changes', [ChangeController::class, 'index'])->name('application.changes.index');
        Route::get('applications/{application}/changes/{change}', [ChangeController::class, 'show'])->name('application.changes.show');
    });
    
    Route::middleware(['permission:create-changes'])->group(function () {
        Route::get('{application}/changes/create', [ChangeController::class, 'create'])->name('application.changes.create');
        Route::post('{application}/changes', [ChangeController::class, 'store'])->name('application.changes.store');
    });
    
    Route::middleware(['permission:edit-changes'])->group(function () {
        Route::get('changes/{change}/edit', [ChangeController::class, 'edit'])->name('changes.edit');
        Route::put('changes/{change}', [ChangeController::class, 'update'])->name('changes.update');
    });
    
    Route::middleware(['permission:delete-changes'])->group(function () {
        Route::delete('changes/{change}', [ChangeController::class, 'destroy'])->name('changes.destroy');
        Route::delete('applications/{application}/changes/{change}', [ChangeController::class, 'destroy'])->name('application.changes.destroy');
    });
    
    Route::middleware(['permission:approve-changes'])->group(function () {
        Route::patch('changes/{change}/approve', [ChangeController::class, 'approve'])->name('changes.approve');
        Route::patch('changes/{change}/reject', [ChangeController::class, 'reject'])->name('changes.reject');
    });
    
    // Role and Permission Management Routes (Protected by permissions)
    // Create routes must come before parameterized routes
    Route::middleware(['permission:create-roles'])->group(function () {
        Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
    });
    
    Route::middleware(['permission:view-roles'])->group(function () {
        Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles-data', [RoleController::class, 'index'])->name('roles.data');
        Route::get('roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    });
    
    Route::middleware(['permission:edit-roles'])->group(function () {
        Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    });
    
    Route::middleware(['permission:delete-roles'])->group(function () {
        Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });
    
    // Permission Management Routes (Protected by permissions)
    // Create routes must come before parameterized routes
    Route::middleware(['permission:create-permissions'])->group(function () {
        Route::get('permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('permissions', [PermissionController::class, 'store'])->name('permissions.store');
    });
    
    Route::middleware(['permission:view-permissions'])->group(function () {
        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/permissions-data', [PermissionController::class, 'index'])->name('permissions.data');
        Route::get('permissions/{permission}', [PermissionController::class, 'show'])->name('permissions.show');
    });
    
    Route::middleware(['permission:edit-permissions'])->group(function () {
        Route::get('permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    });
    
    Route::middleware(['permission:delete-permissions'])->group(function () {
        Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });
    
    // User Management Routes (Protected by permissions)
    // Create routes must come before parameterized routes
    Route::middleware(['permission:create-users'])->group(function () {
        Route::get('users/create', [UserManagementController::class, 'create'])->name('users.create');
        Route::post('users', [UserManagementController::class, 'store'])->name('users.store');
    });
    
    Route::middleware(['permission:view-users'])->group(function () {
        Route::get('users', [UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users-data', [UserManagementController::class, 'index'])->name('users.data');
        Route::get('users/{user}', [UserManagementController::class, 'show'])->name('users.show');
    });
    
    Route::middleware(['permission:edit-users'])->group(function () {
        Route::get('users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    });
    
    Route::middleware(['permission:delete-users'])->group(function () {
        Route::delete('users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
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
