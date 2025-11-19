<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pendonor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterOTP as OtpMail;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Buat user
            $otpCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $otpExpiresAt = Carbon::now()->addMinutes(10);

            // Buat user dengan OTP
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pendonor',
                'otp_code' => $otpCode,
                'otp_expires_at' => $otpExpiresAt,
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

            Mail::to($user->email)->send(new OtpMail($otpCode, $user->nama));
            
            DB::commit();

            event(new Registered($user));
            return redirect()->route('otp.verify', ['email' => $user->email])
                ->with('success', 'Registrasi berhasil! Silakan verifikasi kode OTP yang dikirim ke email Anda.');

        } catch (\Exception $e) {
            DB::rollback();
            
            // Tampilkan error untuk debugging
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function showOtpForm(Request $request)
    {
        $email = $request->query('email');
        return view('auth.verify-otp', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'Email tidak ditemukan']);
        }

        if ($user->is_verified) {
            return redirect()->route('login')->with('info', 'Akun Anda sudah diverifikasi. Silakan tunggu persetujuan admin.');
        }

        if ($user->otp_code !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah']);
        }

        if (Carbon::now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan kirim ulang.']);
        }

        // Verifikasi berhasil
        $user->update([
            'is_verified' => true,
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        return redirect()->route('login')->with('success', 'Verifikasi berhasil! Akun Anda sedang menunggu persetujuan admin.');
    }

    public function resendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        if ($user->is_verified) {
            return back()->withErrors(['email' => 'Akun sudah diverifikasi']);
        }

        // Generate OTP baru
        $otpCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $otpExpiresAt = Carbon::now()->addMinutes(10);

        $user->update([
            'otp_code' => $otpCode,
            'otp_expires_at' => $otpExpiresAt,
        ]);

        // TODO: Kirim OTP via Email
        Mail::to($user->email)->send(new OtpMail($otpCode, $user->nama));

        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda');
    }
        protected function validator(array $data)
    {
        return Validator::make($data, [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'no_telepon' => ['required', 'string', 'max:15', 'regex:/^08[0-9]{8,13}$/'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'golongan_darah' => ['required', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'berat_badan' => ['required', 'numeric', 'min:1'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'nik' => ['nullable', 'string', 'size:16', 'unique:pendonor,NIK'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required', 'accepted'],
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
    }
}