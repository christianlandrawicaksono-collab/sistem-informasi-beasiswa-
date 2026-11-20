<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ReviewerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - SCOLA (Sistem Informasi Beasiswa UNIKA)
|--------------------------------------------------------------------------
*/

// Halaman Publik
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/beasiswa/{beasiswa}', [LandingController::class, 'show'])->name('beasiswa.detail');

// Autentikasi Pengguna
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Portal Mahasiswa (Pendaftar)
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/profil', [MahasiswaController::class, 'profil'])->name('profil');
    Route::put('/profil', [MahasiswaController::class, 'updateProfil'])->name('profil.update');
    Route::post('/beasiswa/{beasiswa}/ajukan', [MahasiswaController::class, 'ajukan'])->name('ajukan');
    Route::get('/pengajuan/{pengajuan}/berkas', [MahasiswaController::class, 'berkas'])->name('berkas');
    Route::post('/pengajuan/{pengajuan}/berkas', [MahasiswaController::class, 'uploadBerkas'])->name('berkas.upload');
    Route::post('/pengajuan/{pengajuan}/submit', [MahasiswaController::class, 'submitFinal'])->name('submit');
});

// Portal Admin / Staf Penyelenggara Kemahasiswaan
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/beasiswa', [AdminController::class, 'beasiswaIndex'])->name('beasiswa.index');
    Route::get('/beasiswa/create', [AdminController::class, 'beasiswaCreate'])->name('beasiswa.create');
    Route::post('/beasiswa', [AdminController::class, 'beasiswaStore'])->name('beasiswa.store');
    Route::get('/verifikasi/{pengajuan}', [AdminController::class, 'verifikasiBerkas'])->name('verifikasi');
    Route::patch('/berkas/{berkas}/status', [AdminController::class, 'updateStatusBerkas'])->name('berkas.status');
    Route::patch('/pengajuan/{pengajuan}/status', [AdminController::class, 'tetapkanStatus'])->name('pengajuan.status');
});

// Portal Tim Penyeleksi (Reviewer & SPK SAW)
Route::middleware(['auth', 'role:reviewer,admin'])->prefix('reviewer')->name('reviewer.')->group(function () {
    Route::get('/dashboard', [ReviewerController::class, 'dashboard'])->name('dashboard');
    Route::post('/beasiswa/{beasiswa}/hitung-saw', [ReviewerController::class, 'hitungSaw'])->name('hitung.saw');
});
