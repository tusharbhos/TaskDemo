<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\EmployeeController;

// ── Root ──────────────────────────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

// ── Guest routes (unauthenticated only) ───────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// ── Authenticated routes ───────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dealer area — only accessible to users with 'dealer' role
    Route::middleware('role:dealer')->prefix('dealer')->name('dealer.')->group(function () {
        Route::get('/dashboard', [DealerController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile',   [DealerController::class, 'editProfile'])->name('profile');
        Route::post('/profile',  [DealerController::class, 'updateProfile'])->name('profile.update');
    });

    // Employee area — only accessible to users with 'employee' role
    Route::middleware('role:employee')->prefix('employee')->name('employee.')->group(function () {
        Route::get('/dashboard',   [EmployeeController::class, 'dashboard'])->name('dashboard');
        Route::get('/dealer/{id}', [EmployeeController::class, 'viewDealer'])->name('dealer.view');
    });
});
