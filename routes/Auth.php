<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');

    // Registration Routes
    Route::get('/register/mahasiswa', [AuthController::class, 'showMahasiswaRegistrationForm'])->name('register.mahasiswa');
    Route::post('/register/mahasiswa', [AuthController::class, 'registerMahasiswa']);
    Route::get('/register/dosen', [AuthController::class, 'showDosenRegistrationForm'])->name('register.dosen');
    Route::post('/register/dosen', [AuthController::class, 'registerDosen']);

    // Socialite Routes
    Route::get('/auth/google', [SocialiteController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [SocialiteController::class, 'callback'])->name('google.callback');
});
