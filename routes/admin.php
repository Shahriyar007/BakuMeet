<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminEstablishmentController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.attempt');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/establishments', [AdminEstablishmentController::class, 'index'])->name('admin.establishments.index');
    Route::post('/establishments/{establishment}/approve', [AdminEstablishmentController::class, 'approve'])->name('admin.establishments.approve');
    Route::post('/establishments/{establishment}/reject', [AdminEstablishmentController::class, 'reject'])->name('admin.establishments.reject');

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});
