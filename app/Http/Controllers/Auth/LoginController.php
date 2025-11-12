<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Http\Controllers\Auth\LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan role (case-insensitive)
            $role = strtolower($user->role);
            
            switch ($role) {
                case 'admin':
                    return redirect()->intended(route('admin.dashboard'));
                case 'staf':
                    return redirect()->intended(route('staf.dashboard'));
                case 'pendonor':
                    return redirect()->intended(route('pendonor.dashboard'));
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors([
                        'email' => 'Role tidak valid.',
                    ]);
            }
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}