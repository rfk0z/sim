<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\{
    AdministrasiController,
    Auth\AuthController,
    BerandaController,
    PengumumanController,
    BeritaController,
    DashboardController,
    SocialiteController,
    UserProfileController
};
use App\Http\Controllers\Admin\{
    TahunAjarController,
    ProgramStudiController,
    BimbinganController,
    UserController
};

//publik

Route::get('/', [BerandaController::class, 'index'])->name('Beranda');

// autentikasi rute
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
    // Register Mahasiswa
    Route::get('/register/mahasiswa', [AuthController::class, 'showMahasiswaRegistrationForm'])->name('register.mahasiswa');
    Route::post('/register/mahasiswa', [AuthController::class, 'registerMahasiswa']);

    Route::get('/register/dosen', [AuthController::class, 'showDosenRegistrationForm'])->name('register.dosen');
    Route::post('/register/dosen', [AuthController::class, 'registerDosen']);

    // Socialite rute
    Route::get('/auth/google', [SocialiteController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [SocialiteController::class, 'callback'])->name('google.callback');
});

// public informasi rute
Route::prefix('informasi')->group(function () {
    Route::get('/berita', [BeritaController::class, 'index'])->name('index.berita');
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
});

// public
Route::prefix('mhs')->group(function () {
    Route::get('/pengajuan', [BeritaController::class, 'show'])->name('pengajuan');
    Route::get('/jadwal', [BeritaController::class, 'show'])->name('jadwal');
    Route::get('/peraturan', [BeritaController::class, 'show'])->name('peraturan');
});

/*
|--------------------------------------------------------------------------
| otentikasi rute
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // keluat
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profil manajemen
    Route::prefix('profil')->group(function () {
        Route::get('/', [UserProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/', [UserProfileController::class, 'update'])->name('profile.update');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:1'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    // User Management
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'showlist'])->name('user.list.index');
        Route::post('/create', [UserController::class, 'create'])->name('user.create');
        Route::put('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::get('/{id}/show', [UserController::class, 'showid'])->name('user.show');
    });
    // Resource rute, tahunajar, program studi, bimbingan
    Route::resource('tahun_ajar', TahunAjarController::class);
    Route::resource('program_studi', ProgramStudiController::class);
    Route::resource('bimbingan', BimbinganController::class);
});

//dosen rute
Route::middleware(['auth', 'role:2'])->prefix('dosen')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

//mahasiswa rute
Route::middleware(['auth', 'role:3'])->prefix('mhs')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});
