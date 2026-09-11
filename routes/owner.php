<?php

use App\Http\Controllers\Owner\EstablishmentController;
use App\Http\Controllers\Owner\OwnerAuthController;
use App\Http\Controllers\Owner\OwnerDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:business')->group(function () {
    Route::get('/login', [OwnerAuthController::class, 'showLoginForm'])->name('owner.login');
    Route::post('/login', [OwnerAuthController::class, 'login'])->name('owner.login.attempt');

    Route::get('/register', [OwnerAuthController::class, 'showRegisterForm'])->name('owner.register');
    Route::post('/register', [OwnerAuthController::class, 'register'])->name('owner.register.attempt');
});

Route::middleware('auth:business')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');

    Route::get('/establishment/create', [EstablishmentController::class, 'create'])->name('owner.establishments.create');
    Route::post('/establishment', [EstablishmentController::class, 'store'])->name('owner.establishments.store');
    Route::get('/establishment/edit', [EstablishmentController::class, 'edit'])->name('owner.establishments.edit');
    Route::put('/establishment', [EstablishmentController::class, 'update'])->name('owner.establishments.update');

    Route::post('/logout', [OwnerAuthController::class, 'logout'])->name('owner.logout');
});
