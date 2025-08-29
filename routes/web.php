<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', 'login');


Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [PasswordResetController::class, 'showForgotForm'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink'])
        ->name('password.email')
        ->middleware('throttle:1,1');

    Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');

    Route::get('/login', fn() => Inertia::render('Auth/Login', []))->name('login');
    Route::post('/login', LoginController::class);
});

Route::get('/dashboard', fn() => Inertia::render('Dashboard', []))->middleware('auth');
