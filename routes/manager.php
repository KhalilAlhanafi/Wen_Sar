<?php

use App\Http\Controllers\Manager\AuthController;
use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\GovernorateController;
use App\Http\Controllers\Manager\DistrictController;
use App\Http\Controllers\Manager\SubAreaController;
use App\Http\Controllers\Manager\BusinessController;
use App\Http\Controllers\Manager\OwnerController;
use App\Http\Controllers\Manager\ApprovalController;
use Illuminate\Support\Facades\Route;

// Public manager routes
Route::prefix('manager')->name('manager.')->group(function () {
    // Setup (only when no managers exist)
    Route::get('/setup', [AuthController::class, 'showSetupForm'])->name('setup');
    Route::post('/setup', [AuthController::class, 'setup']);

    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected manager routes
    Route::middleware(['manager.auth'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Governorates CRUD
        Route::resource('governorates', GovernorateController::class);

        // Districts CRUD
        Route::resource('districts', DistrictController::class);

        // Sub Areas CRUD
        Route::resource('sub-areas', SubAreaController::class);

        // Business Owners
        Route::get('/owners', [OwnerController::class, 'index'])->name('owners.index');
        Route::get('/owners/{user}', [OwnerController::class, 'show'])->name('owners.show');
        Route::delete('/owners/{user}', [OwnerController::class, 'destroy'])->name('owners.destroy');

        // All Businesses (approved)
        Route::get('/businesses', [BusinessController::class, 'index'])->name('businesses.index');
        Route::get('/businesses/{business}', [BusinessController::class, 'show'])->name('businesses.show');
        Route::get('/businesses/{business}/edit', [BusinessController::class, 'edit'])->name('businesses.edit');
        Route::put('/businesses/{business}', [BusinessController::class, 'update'])->name('businesses.update');
        Route::delete('/businesses/{business}', [BusinessController::class, 'destroy'])->name('businesses.destroy');

        // Approvals - Order matters: specific routes first, then parameterized
        Route::get('/approvals/pending', [ApprovalController::class, 'pending'])->name('approvals.pending');
        Route::get('/approvals/expiring', [ApprovalController::class, 'expiring'])->name('approvals.expiring');
        Route::get('/approvals/{business}', [ApprovalController::class, 'show'])->name('approvals.show');
        Route::post('/approvals/{business}/approve', [ApprovalController::class, 'approve'])->name('approvals.approve');
        Route::post('/approvals/{business}/reject', [ApprovalController::class, 'reject'])->name('approvals.reject');
    });
});
