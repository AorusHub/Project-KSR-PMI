<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Redirect root URL to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard route with role-based redirection
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if (!$user) {
        return redirect('/login');
    }
    
    // Redirect based on user role
    switch ($user->role) {
        case 'Admin':
            return app(DashboardController::class)->adminDashboard();
        case 'Staf':
            return app(DashboardController::class)->stafDashboard();
        case 'Pendonor':
            return app(DashboardController::class)->pendonorDashboard();
        default:
            return view('dashboard'); // fallback to default dashboard
    }
})->middleware(['auth'])->name('dashboard');

// Specific dashboard routes for each role
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])
        ->middleware('role:Admin')->name('admin.dashboard');
    
    Route::get('/staf/dashboard', [DashboardController::class, 'stafDashboard'])
        ->middleware('role:Staf')->name('staf.dashboard');
    
    Route::get('/pendonor/dashboard', [DashboardController::class, 'pendonorDashboard'])
        ->middleware('role:Pendonor')->name('pendonor.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';