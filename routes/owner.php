<?php

use App\Http\Controllers\Owner\OwnerAuthController;
use App\Http\Controllers\Owner\OwnerDashboardController;
use Illuminate\Support\Facades\Route;

// Guest-only owner routes (not yet logged in)
Route::middleware('guest:business')->group(function () {
    Route::get('/login', [OwnerAuthController::class, 'showLoginForm'])->name('owner.login');
    Route::post('/login', [OwnerAuthController::class, 'login'])->name('owner.login.attempt');

    Route::get('/register', [OwnerAuthController::class, 'showRegisterForm'])->name('owner.register');
    Route::post('/register', [OwnerAuthController::class, 'register'])->name('owner.register.attempt');
});

// Authenticated owner routes
Route::middleware('auth:business')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');

    Route::post('/logout', [OwnerAuthController::class, 'logout'])->name('owner.logout');
});
