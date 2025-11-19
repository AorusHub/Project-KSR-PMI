<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * Display the password reset view (forgot-password.blade.php).
     */
    public function create(Request $request, $token = null)
    {
        // Validasi token dari session
        if ($token !== session('password_reset_token')) {
            return redirect()->route('password.request')
                ->withErrors(['token' => 'Token reset password tidak valid atau sudah kadaluarsa.']);
        }

        // Check expiration
        if (now()->greaterThan(session('password_reset_expires'))) {
            session()->forget(['password_reset_token', 'password_reset_email', 'password_reset_expires']);
            return redirect()->route('password.request')
                ->withErrors(['token' => 'Token reset password sudah kadaluarsa. Silakan kirim ulang.']);
        }

        return view('auth.forgot-password', [
            'token' => $token,
            'email' => $request->email ?? session('password_reset_email')
        ]);
    }

    /**
     * Handle resetting the user's password.
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Validasi token dan email
        if ($request->token !== session('password_reset_token') || 
            $request->email !== session('password_reset_email')) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Token atau email tidak valid']);
            }
            return back()->withErrors(['email' => 'Token atau email tidak valid']);
        }

        // Check expiration
        if (now()->greaterThan(session('password_reset_expires'))) {
            session()->forget(['password_reset_token', 'password_reset_email', 'password_reset_expires']);
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Token sudah kadaluarsa']);
            }
            return redirect()->route('password.request')
                ->withErrors(['token' => 'Token reset password sudah kadaluarsa']);
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Email tidak ditemukan']);
            }
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        $user->forceFill([
            'password' => Hash::make($request->password)
        ])->setRememberToken(Str::random(60));

        $user->save();

        // Clear session
        session()->forget(['password_reset_token', 'password_reset_email', 'password_reset_expires']);

        // Return JSON for AJAX request
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        // Normal redirect
        return redirect()->route('login')
            ->with('success', 'Password berhasil direset! Silakan login dengan password baru Anda.');
    }
}