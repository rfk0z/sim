<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdministrasiController,
    Auth\AuthController,
    BerandaController,
    PengumumanController,
    BeritaController,
    ProfilebsiController,
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
use App\Http\Controllers\Dosen\{
    DashboardDosenController,
    DosenProfileController,
    DosenBimbinganController,
    KomentarBimbinganController,
};

use App\Http\Controllers\mhs\{
    DashboardMhsController,
    MhsBimbinganController,
    KomentarMahasiswaController,
    MhsProfileController,
};

/*
|--------------------------------------------------------------------------
| RUTE PUBLIK
|--------------------------------------------------------------------------
| Rute yang dapat diakses oleh semua pengunjung tanpa autentikasi
*/
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/profil-ubsi', [ProfilebsiController::class, 'index'])->name('profil.index');
Route::get('/berita', [BeritaController::class, 'index'])->name('index.berita');
Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');

/*
|--------------------------------------------------------------------------
| RUTE TAMU (Belum Login)
|--------------------------------------------------------------------------
| Rute khusus untuk pengguna yang belum melakukan autentikasi
*/
Route::middleware('guest')->group(function () {
    // Halaman Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');

    // Halaman Registrasi
    Route::get('/register/mahasiswa', [AuthController::class, 'showMahasiswaRegistrationForm'])->name('register.mahasiswa');
    Route::post('/register/mahasiswa', [AuthController::class, 'registerMahasiswa']);
    Route::get('/register/dosen', [AuthController::class, 'showDosenRegistrationForm'])->name('register.dosen');
    Route::post('/register/dosen', [AuthController::class, 'registerDosen']);

    // Autentikasi Social Media
    Route::get('/auth/google', [SocialiteController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [SocialiteController::class, 'callback'])->name('google.callback');
});

/*
|--------------------------------------------------------------------------
| RUTE UMUM MAHASISWA (Tanpa Autentikasi)
|--------------------------------------------------------------------------
*/
Route::prefix('mhs')->group(function () {
    Route::get('/pengajuan', [BeritaController::class, 'show'])->name('pengajuan');
    Route::get('/jadwal', [BeritaController::class, 'show'])->name('jadwal');
    Route::get('/peraturan', [BeritaController::class, 'show'])->name('peraturan');
});

/*
|--------------------------------------------------------------------------
| RUTE TERAUTENTIKASI
|--------------------------------------------------------------------------
| Rute yang memerlukan login untuk mengakses
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| RUTE ADMIN
|--------------------------------------------------------------------------
| Rute khusus untuk pengguna dengan role admin (role:1)
*/
Route::middleware(['auth', 'role:1'])->prefix('admin')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Manajemen Profil Admin
    Route::get('/profil', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profil', [UserProfileController::class, 'update'])->name('profile.update');

    // Manajemen Pengguna
    Route::get('/users', [UserController::class, 'showlist'])->name('user.list.index');
    Route::post('/users/create', [UserController::class, 'create'])->name('user.create');
    Route::put('/users/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::get('/users/{id}/show', [UserController::class, 'showid'])->name('user.show');

    // Manajemen Resource (CRUD Lengkap)
    Route::resource('tahun_ajar', TahunAjarController::class);
    Route::resource('program_studi', ProgramStudiController::class);
    Route::resource('bimbingan', BimbinganController::class);
});

/*
|--------------------------------------------------------------------------
| RUTE DOSEN
|--------------------------------------------------------------------------
| Rute khusus untuk pengguna dengan role dosen (role:2)
*/
Route::middleware(['auth', 'role:2'])->prefix('dosen')->group(function () {
    // Dashboard Dosen
    Route::get('/dashboard', [DashboardDosenController::class, 'index'])->name('dosen.dashboard');

    // Manajemen Profil Dosen
    Route::get('/profil', [DosenProfileController::class, 'edit'])->name('dosen.profile.edit');
    Route::post('/profil', [DosenProfileController::class, 'update'])->name('dosen.profile.update');

    // Manajemen Bimbingan
    Route::get('/bimbingan', [DosenBimbinganController::class, 'index'])->name('dosen.bimbingan.index');
    Route::get('/bimbingan/{id}', [DosenBimbinganController::class, 'show'])->name('dosen.bimbingan.show');
    Route::get('/bimbingan/{id}/edit', [DosenBimbinganController::class, 'edit'])->name('dosen.bimbingan.edit');
    Route::put('/bimbingan/{id}', [DosenBimbinganController::class, 'update'])->name('dosen.bimbingan.update');

    // Hapus Dokumen Bimbingan
    Route::delete('/bimbingan/dokumen/{id}', [DosenBimbinganController::class, 'deleteDokumen'])->name('dosen.bimbingan.dokumen.delete');

    // Manajemen Komentar Bimbingan
    Route::post('/bimbingan/{id_bimbingan}/komentar', [KomentarBimbinganController::class, 'store'])->name('bimbingan.komentar.store');
    Route::get('/bimbingan/{id_bimbingan}/komentar/{id_komentar}', [KomentarBimbinganController::class, 'show'])->name('bimbingan.komentar.show');
});

/*
|--------------------------------------------------------------------------
| RUTE MAHASISWA
|--------------------------------------------------------------------------
| Rute khusus untuk pengguna dengan role mahasiswa (role:3)
*/
Route::middleware(['auth', 'role:3'])->prefix('mhs')->group(function () {
    // Dashboard Mahasiswa
    Route::get('/dashboard', [DashboardMhsController::class, 'index'])->name('mahasiswa.dashboard');
    // Manajemen Profil mahaiswa
    Route::get('/profil', [MhsProfileController::class, 'edit'])->name('mhs.profile.edit');
    Route::post('/profil', [MhsProfileController::class, 'update'])->name('mhs.profile.update');

    // Manajemen Bimbingan
    Route::get('/bimbingan', [MhsBimbinganController::class, 'index'])->name('mhs.bimbingan.index');
    Route::get('/bimbingan/create', [MhsBimbinganController::class, 'create'])->name('mhs.bimbingan.create');
    Route::post('/bimbingan', [MhsBimbinganController::class, 'store'])->name('mhs.bimbingan.store');
    Route::get('/bimbingan/{id}', [MhsBimbinganController::class, 'show'])->name('mhs.bimbingan.show');
    Route::get('/bimbingan/{id}/edit', [MhsBimbinganController::class, 'edit'])->name('mhs.bimbingan.edit');
    Route::put('/bimbingan/{id}', [MhsBimbinganController::class, 'update'])->name('mhs.bimbingan.update');
    Route::delete('/bimbingan/{id}', [MhsBimbinganController::class, 'destroy'])->name('mhs.bimbingan.destroy');
        // Manajemen Komentar Bimbingan
    Route::post('/bimbingan/{id_bimbingan}/komentar', [KomentarMahasiswaController::class, 'store'])->name('bim.komentar.store');
});
