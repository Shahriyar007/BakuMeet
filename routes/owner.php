<?php

use Illuminate\Support\Facades\Route;

// Guest-only owner routes (not yet logged in)
Route::middleware('guest:business')->group(function () {
    Route::get('/login', function () {
        return 'owner login form placeholder';
    })->name('owner.login');

    Route::get('/register', function () {
        return 'owner register form placeholder';
    })->name('owner.register');
});

// Authenticated owner routes
Route::middleware('auth:business')->group(function () {
    Route::get('/dashboard', function () {
        return 'owner dashboard placeholder';
    })->name('owner.dashboard');
});
