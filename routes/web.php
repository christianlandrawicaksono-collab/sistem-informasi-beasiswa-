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

// Helper Setup Database Otomatis via Browser
Route::get('/setup-database', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $mig = \Illuminate\Support\Facades\Artisan::output();

        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        $seed = \Illuminate\Support\Facades\Artisan::output();

        \Illuminate\Support\Facades\Artisan::call('storage:link');
        $link = \Illuminate\Support\Facades\Artisan::output();

        return "<pre style='background:#0f172a;color:#10b981;padding:24px;border-radius:12px;font-family:monospace;font-size:14px;line-height:1.5;'>=== BERHASIL SETUP DATABASE SCOLA ===\n\n" . e($mig) . "\n" . e($seed) . "\n" . e($link) . "\n<a href=\"/\" style=\"color:#f59e0b;font-weight:bold;text-decoration:underline;\">>>> KLIK DI SINI UNTUK BUKA BERANDA SCOLA <<<</a></pre>";
    } catch (\Throwable $e) {
        return "<pre style='background:#0f172a;color:#ef4444;padding:24px;border-radius:12px;font-family:monospace;font-size:14px;line-height:1.5;'>=== GAGAL KONEKSI / SETUP DATABASE ===\n\nPesan Error: " . e($e->getMessage()) . "\n\nPastikan Service MySQL sudah dibuat di Railway dan variabel DB_HOST dsb sudah dimasukkan di tab Variables.</pre>";
    }
});
