<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\routes\web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

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
    
    // Tambahkan route pendonor lainnya di sini
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