<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\KelolaAdminController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])
        ->middleware('throttle:5,10')
        ->name('register.store');

    // Lupa & reset password
    Route::get('/lupa-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/lupa-password', [PasswordResetController::class, 'email'])
        ->middleware('throttle:5,10')
        ->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.store');
});

Route::middleware(['auth', 'active'])->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::put('/profil/nama', [ProfilController::class, 'updateNama'])->name('profil.nama');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');

    // Hanya Super Admin
    Route::middleware('super_admin')->prefix('kelola-admin')->name('akun.')->group(function () {
        Route::get('/', [KelolaAdminController::class, 'index'])->name('index');
        Route::post('/{user}/konfirmasi', [KelolaAdminController::class, 'konfirmasi'])->name('konfirmasi');
        Route::post('/{user}/tolak', [KelolaAdminController::class, 'tolak'])->name('tolak');
        Route::post('/{user}/status', [KelolaAdminController::class, 'status'])->name('status');
    });
});