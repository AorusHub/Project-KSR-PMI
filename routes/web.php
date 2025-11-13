<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KegiatanDonorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\InfoUtdController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\KegiatanController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// ✅ PUBLIC KEGIATAN ROUTES (untuk user biasa/guest)
Route::prefix('kegiatan-donor')->name('kegiatan.')->group(function () {
    Route::get('/', [KegiatanDonorController::class, 'index'])->name('index');
    Route::get('/{id}', [KegiatanDonorController::class, 'show'])->name('show');
});

Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');
Route::post('/kontak/send', [PageController::class, 'sendKontak'])->name('kontak.send');
Route::get('/tentang-kami', [PageController::class, 'tentangKami'])->name('tentang-kami');
Route::get('/info-utd', [InfoUtdController::class, 'index'])->name('info-utd');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    
    // ✅ KEGIATAN ROUTES (untuk admin)
    Route::prefix('kegiatan')->name('kegiatan.')->group(function () {
        Route::get('/', [KegiatanController::class, 'index'])->name('index');
        Route::post('/', [KegiatanController::class, 'store'])->name('store');
        Route::get('/{id}', [KegiatanController::class, 'show'])->name('show');
        Route::put('/{id}', [KegiatanController::class, 'update'])->name('update');
        Route::delete('/{id}', [KegiatanController::class, 'destroy'])->name('destroy');
    });
    
    // USER MANAGEMENT ROUTES
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/{id}/riwayat', [UserManagementController::class, 'riwayatDonasi'])->name('riwayat');
        Route::delete('/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| STAF ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:staf'])->prefix('staf')->name('staf.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'stafDashboard'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| PENDONOR ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pendonor'])->prefix('pendonor')->name('pendonor.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'pendonorDashboard'])->name('dashboard');
    Route::get('/riwayat-donor', [DashboardController::class, 'riwayatDonor'])->name('riwayat-donor');
});

/*
|--------------------------------------------------------------------------
| PROFILE ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
});