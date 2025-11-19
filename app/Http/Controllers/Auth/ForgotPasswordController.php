<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\RegisterOTP;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    /**
     * Display the forgot password view.
     */
    public function create()
    {
        return view('auth.forgot-email');
    }

    /**
     * Handle sending OTP to email.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar',
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate OTP
        $otpCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $otpExpiresAt = now()->addMinutes(10);

        // Update user dengan OTP
        $user->update([
            'otp_code' => $otpCode,
            'otp_expires_at' => $otpExpiresAt,
        ]);

        // Kirim OTP via email
        Mail::to($user->email)->send(new RegisterOTP($otpCode, $user->nama));

        return redirect()->route('password.verify.otp.form', ['email' => $user->email])
            ->with('success', 'Kode OTP telah dikirim ke email Anda. Silakan cek inbox atau folder spam.');
    }

    /**
     * Show OTP verification form.
     */
    public function showVerifyOtpForm(Request $request)
    {
        $email = $request->query('email') ?? session('email');
        return view('auth.verify-forgot-otp', compact('email'));
    }

    /**
     * Verify OTP.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'otp.required' => 'Kode OTP wajib diisi',
            'otp.size' => 'Kode OTP harus 6 digit',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Email tidak ditemukan. Silakan coba lagi.']);
        }

        // Check if OTP exists
        if (!$user->otp_code) {
            return back()
                ->withInput()
                ->withErrors(['otp' => 'Kode OTP tidak ditemukan. Silakan kirim ulang OTP.']);
        }

        // Check if OTP matches
        if ($user->otp_code !== $request->otp) {
            return back()
                ->withInput()
                ->withErrors(['otp' => 'Kode OTP yang Anda masukkan salah. Silakan cek kembali email Anda.']);
        }

        // Check if OTP expired
        if (now()->greaterThan($user->otp_expires_at)) {
            return back()
                ->withInput()
                ->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan kirim ulang OTP.']);
        }

        // OTP valid, clear OTP
        $user->update([
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        // Generate token untuk reset password
        $token = Str::random(64);
        
        // Simpan token ke session
        session([
            'password_reset_token' => $token,
            'password_reset_email' => $user->email,
            'password_reset_expires' => now()->addMinutes(60)
        ]);

        // Redirect ke halaman reset password
        return redirect()->route('password.reset', ['token' => $token, 'email' => $user->email])
            ->with('success', 'Verifikasi OTP berhasil! Silakan buat password baru Anda.');
    }

    /**
     * Resend OTP.
     */
    public function resendOtp(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email']);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Email tidak ditemukan dalam sistem'
                ], 404);
            }

            // Generate OTP baru
            $otpCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $otpExpiresAt = now()->addMinutes(10);

            $user->update([
                'otp_code' => $otpCode,
                'otp_expires_at' => $otpExpiresAt,
            ]);

            // Kirim OTP via email
            Mail::to($user->email)->send(new RegisterOTP($otpCode, $user->nama));

            return response()->json([
                'success' => true, 
                'message' => 'Kode OTP baru telah dikirim ke email Anda'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim OTP. Silakan coba lagi.'
            ], 500);
        }
    }
}