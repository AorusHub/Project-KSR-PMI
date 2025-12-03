<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KegiatanDonorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\InfoUtdController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PermintaanDonorController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\PendonorController;
use App\Http\Controllers\StokDarahController;
// ...existing code...
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

    // OTP Routes
    Route::get('/verify-otp', [RegisterController::class, 'showOtpForm'])->name('otp.verify');
    Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('verify.otp');
    Route::post('/resend-otp', [RegisterController::class, 'resendOtp'])->name('resend.otp');

    // Forgot Password Routes
    Route::get('/forgot-email', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-email', [ForgotPasswordController::class, 'store'])->name('password.email');

    // Forgot Password OTP Routes
    Route::get('/verify-forgot-otp', [ForgotPasswordController::class, 'showVerifyOtpForm'])->name('password.verify.otp.form');
    Route::post('/verify-forgot-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify.otp');
    Route::post('/resend-forgot-otp', [ForgotPasswordController::class, 'resendOtp'])->name('password.resend.otp');

    // Reset Password Routes (Halaman input password baru)
    Route::get('/forgot-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/forgot-password', [ResetPasswordController::class, 'store'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    
    // USER MANAGEMENT ROUTES
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/{id}/riwayat', [UserManagementController::class, 'riwayatDonasi'])->name('riwayat');
        Route::delete('/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    // ✅ Kegiatan & Partisipan Routes
    Route::get('/kegiatan/{id}', [KegiatanDonorController::class, 'adminShow'])->name('kegiatan.show');
    Route::get('/kegiatan/{id}/partisipan', [KegiatanDonorController::class, 'showPartisipan'])->name('kegiatan.partisipan');
    Route::get('/kegiatan/{id}/partisipan/search', [KegiatanDonorController::class, 'showPartisipan'])->name('kegiatan.partisipan.search');
    
     // ✅ Pendonor Routes
    Route::get('/pendonor/{id}', [PendonorController::class, 'show'])->name('pendonor.show');
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

    // Cek Kelayakan
    Route::get('/cek-kelayakan', [DashboardController::class, 'cekKelayakan'])->name('cek-kelayakan');
    Route::get('/cek-kelayakan-donor', [DashboardController::class, 'cekKelayakanDonor'])->name('cek-kelayakan-donor'); // ✅ TAMBAHKAN INI
    Route::get('/riwayat-donor/export-pdf', [PendonorController::class, 'exportPdf'])->name('riwayat-donor.export-pdf');
    Route::post('/cek-kelayakan-donor/submit', [DashboardController::class, 'submitKelayakan'])->name('cek-kelayakan.submit');

    // Butuh Darah Cepat
    // Route::get('/butuh-darah-cepat', [DashboardController::class, 'butuhDarahCepat'])->name('butuh-darah-cepat');

    // Formulir Permintaan Darah
    Route::get('/formulir-permintaan-darah', [PermintaanDonorController::class, 'create'])->name('permintaan-darah.create');
    Route::post('/formulir-permintaan-darah', [PermintaanDonorController::class, 'store'])->name('permintaan-darah.simpan');
    Route::get('/permintaan-darah/{id}/sukses', [PermintaanDonorController::class, 'success'])->name('permintaan-darah.sukses');
    
    // Profile
    Route::get('/profil', [DashboardController::class, 'profil'])->name('profil');
    Route::put('/profil', [DashboardController::class, 'updateProfil'])->name('profil.update');
});

/*
|--------------------------------------------------------------------------
| ADMIN & STAF SHARED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // ✅ MANAJEMEN KEGIATAN (Admin & Staf)
    Route::get('/managemen-kegiatan', [KegiatanDonorController::class, 'adminIndex'])
        ->name('managemen.kegiatan.index');
    
    Route::get('/managemen-kegiatan/create', [KegiatanDonorController::class, 'create'])
        ->name('managemen.kegiatan.create');
    
    Route::post('/managemen-kegiatan', [KegiatanDonorController::class, 'store'])
        ->name('managemen.kegiatan.store');
    
    Route::get('/managemen-kegiatan/{id}/edit', [KegiatanDonorController::class, 'edit'])
        ->name('managemen.kegiatan.edit');
    
    Route::put('/managemen-kegiatan/{id}', [KegiatanDonorController::class, 'update'])
        ->name('managemen.kegiatan.update');
    
    Route::delete('/managemen-kegiatan/{id}', [KegiatanDonorController::class, 'destroy'])
        ->name('managemen.kegiatan.destroy'); 
    
    Route::get('/kegiatan-donor/{id}/peserta', [KegiatanDonorController::class, 'peserta'])
        ->name('kegiatan.peserta');
    Route::get('/kegiatan-donor/{id}/peserta/search', [KegiatanDonorController::class, 'searchPeserta'])
        ->name('kegiatan.peserta.search');
    
    Route::prefix('managemen-permintaan-darurat')->name('managemen.permintaan-darurat.')->group(function () {
        Route::get('/', [PermintaanDonorController::class, 'managemenIndex'])->name('index');
        Route::get('/{id}', [PermintaanDonorController::class, 'managemenShow'])->name('show');
        Route::post('/{id}/update-status', [PermintaanDonorController::class, 'updateStatus'])->name('update-status');
    });

    Route::prefix('stok-darah')->name('stok-darah.')->group(function () {
        Route::get('/', [App\Http\Controllers\StokDarahController::class, 'index'])->name('index');
        Route::post('/update', [App\Http\Controllers\StokDarahController::class, 'update'])->name('update');
    });
    //detail kegiatan
    
    // ✅ ROUTES UNTUK MELIHAT PESERTA KEGIATAN (Admin & Staf only)
    // Route::middleware('role:admin,staf')->group(function () {
    // Route::get('/kegiatan-donor/{id}/peserta', [KegiatanDonorController::class, 'showPeserta'])->name('kegiatan.peserta');
        
    // Route::get('/kegiatan-donor/{id}/peserta/search', [KegiatanDonorController::class, 'searchPeserta'])->name('kegiatan.peserta.search');
    // });
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