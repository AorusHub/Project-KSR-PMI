<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pendonor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Cek apakah sudah verifikasi OTP
            if (!$user->is_verified) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda belum diverifikasi. Silakan verifikasi OTP terlebih dahulu.',
                ]);
            }
            
            // Redirect berdasarkan role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isStaf()) {
                return redirect()->route('staf.dashboard');
            } else {
                return redirect()->route('pendonor.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Tampilkan form register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'no_telepon' => 'required|string|max:15|regex:/^08[0-9]{8,13}$/',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'golongan_darah' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'berat_badan' => 'required|numeric|min:1',
            'alamat' => 'nullable|string|max:500',
            'nik' => 'nullable|string|size:16|unique:pendonor,NIK',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_telepon.required' => 'No. telepon wajib diisi.',
            'no_telepon.regex' => 'Format no. telepon tidak valid. Harus diawali 08.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'golongan_darah.required' => 'Golongan darah wajib dipilih.',
            'berat_badan.required' => 'Berat badan wajib diisi.',
            'berat_badan.min' => 'Berat badan tidak valid.',
            'nik.size' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'terms.accepted' => 'Anda harus menyetujui syarat & ketentuan.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Generate OTP 4 digit
            $otpCode = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            
            // Buat user
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pendonor',
                'otp_code' => $otpCode,
                'otp_expires_at' => Carbon::now()->addMinutes(5),
                'is_verified' => false,
            ]);

            // Buat data pendonor
            Pendonor::create([
                'user_id' => $user->user_id,
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_telepon,
                'NIK' => $request->nik,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'golongan_darah' => $request->golongan_darah,
                'alamat' => $request->alamat,
            ]);

            // Kirim OTP via email
            Mail::raw("Kode OTP Anda: $otpCode\n\nBerlaku selama 5 menit.\n\nTerima kasih,\nKSR PMI UNHAS", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Kode OTP Verifikasi - KSR PMI UNHAS');
            });

            DB::commit();

            return redirect()->route('verify.otp.form')
                             ->with('email', $request->email)
                             ->with('success', 'OTP telah dikirim ke email Anda!');

        } catch (\Exception $e) {
            DB::rollback();
            
            return back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    // Tampilkan form OTP
    public function showVerifyOTP()
    {
        if (!session('email')) {
            return redirect()->route('register');
        }
        
        return view('auth.verify-otp');
    }

    // Verifikasi OTP
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:4',
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus 4 digit.',
        ]);

        $user = User::where('email', session('email'))
                    ->where('otp_code', $request->otp)
                    ->where('otp_expires_at', '>', Carbon::now())
                    ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kadaluarsa.']);
        }

        // Update user sebagai terverifikasi
        $user->update([
            'is_verified' => true,
            'otp_code' => null,
            'otp_expires_at' => null,
            'email_verified_at' => Carbon::now(),
        ]);

        // Login otomatis
        Auth::login($user);

        // Clear session email
        session()->forget('email');

        return redirect()->route('home')->with('success', 'Akun Anda berhasil diverifikasi!');
    }

    // Kirim ulang OTP
    public function resendOTP(Request $request)
    {
        $otpCode = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        
        $user = User::where('email', session('email'))->first();
        
        if ($user) {
            $user->update([
                'otp_code' => $otpCode,
                'otp_expires_at' => Carbon::now()->addMinutes(5),
            ]);

            Mail::raw("Kode OTP Baru Anda: $otpCode\n\nBerlaku selama 5 menit.\n\nTerima kasih,\nKSR PMI UNHAS", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Kode OTP Baru - KSR PMI UNHAS');
            });

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }
}