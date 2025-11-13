<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\routes\web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KegiatanDonorController;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES (Guest Only)
|--------------------------------------------------------------------------
*/
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');
Route::post('/kontak/send', [PageController::class, 'sendKontak'])->name('kontak.send');
Route::get('/tentang-kami', [PageController::class, 'tentangKami'])->name('tentang-kami');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| LOGOUT ROUTE (Authenticated Only)
|--------------------------------------------------------------------------
*/
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    
    Route::get('/kegiatan', [KegiatanDonorController::class, 'adminIndex'])->name('kegiatan.index');
    Route::get('/kegiatan/create', [KegiatanDonorController::class, 'create'])->name('kegiatan.create');
    Route::post('/kegiatan', [KegiatanDonorController::class, 'store'])->name('kegiatan.store');
    Route::get('/kegiatan/{id}', [KegiatanDonorController::class, 'show'])->name('kegiatan.show');
    Route::get('/kegiatan/{id}/edit', [KegiatanDonorController::class, 'edit'])->name('kegiatan.edit');
    Route::put('/kegiatan/{id}', [KegiatanDonorController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{id}', [KegiatanDonorController::class, 'destroy'])->name('kegiatan.destroy');
    
    // Routes lainnya...
    Route::get('/permintaan', function() { return view('dashboard.dev.managemen_permintaan'); })->name('permintaan.index');
    Route::get('/users', function() { return view('dashboard.dev.managemen_pengguna'); })->name('users.index');
    Route::get('/laporan', function() { return view('dashboard.dev.laporan'); })->name('laporan.index');
    // Tambahkan route admin lainnya di sini
    // Route::get('/pendonor', [AdminController::class, 'pendonor'])->name('pendonor');
    // Route::get('/kegiatan', [AdminController::class, 'kegiatan'])->name('kegiatan');
});

/*
|--------------------------------------------------------------------------
| STAF ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:staf'])->prefix('staf')->name('staf.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'stafDashboard'])->name('dashboard');
    
    // Tambahkan route staf lainnya di sini
    // Route::get('/kegiatan', [StafController::class, 'kegiatan'])->name('kegiatan');
});

/*
|--------------------------------------------------------------------------
| PENDONOR ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pendonor'])->prefix('pendonor')->name('pendonor.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'pendonorDashboard'])->name('dashboard');
    Route::get('/riwayat-donor', [DashboardController::class, 'riwayatDonor'])->name('riwayat-donor');
    Route::get('/riwayat-donor/export-pdf', [DashboardController::class, 'exportPDF'])->name('riwayat-donor.export-pdf');
    
    // Tambahkan route pendonor lainnya di sini //
    // Route::get('/kegiatan', [PendonorController::class, 'kegiatan'])->name('kegiatan');
});

/*
|--------------------------------------------------------------------------
| PROFILE ROUTES (All Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
});