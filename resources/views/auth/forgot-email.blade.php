{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\auth\forgot-email.blade.php --}}
@extends('layouts.guest')

@section('title', 'Lupa Password - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        
        {{-- Header --}}
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="Logo KSR PMI" class="mx-auto h-20 w-20 object-contain mb-4" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2280%22 height=%2280%22 viewBox=%220 0 80 80%22%3E%3Ccircle cx=%2240%22 cy=%2240%22 r=%2240%22 fill=%22%23dc2626%22/%3E%3Cpath d=%22M40 15 L48 35 L68 35 L53 48 L58 68 L40 56 L22 68 L27 48 L12 35 L32 35 Z%22 fill=%22white%22/%3E%3C/svg%3E'">
            
            {{-- Icon Lock --}}
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Lupa Password?</h2>
            <p class="text-sm text-gray-600">Masukkan email Anda untuk reset password</p>
        </div>

        {{-- Main Card --}}
        <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-100">
            <form action="{{ route('password.email') }}" method="POST" class="p-6 space-y-6">
                @csrf

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('status'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm">{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Email Input --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            required 
                            autofocus
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                        >
                    </div>
                    @error('email')
                        <p class="mt-2 text-xs text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button 
                    type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 px-4 rounded-lg transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 shadow-md hover:shadow-lg"
                >
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Kirim Kode OTP
                    </span>
                </button>

                {{-- Divider --}}
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-2 bg-white text-gray-500">atau</span>
                    </div>
                </div>

                {{-- Back to Login --}}
                <div class="text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center text-sm font-semibold text-red-600 hover:text-red-700 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Login
                    </a>
                </div>
            </form>
        </div>

        {{-- Info Note --}}
        <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4 shadow-sm">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-semibold text-blue-900 mb-1">Cara Reset Password</h3>
                    <ol class="text-xs text-blue-800 space-y-1 list-decimal list-inside">
                        <li>Masukkan email terdaftar Anda</li>
                        <li>Kami akan mengirim kode OTP ke email</li>
                        <li>Masukkan kode OTP untuk verifikasi</li>
                        <li>Buat password baru Anda</li>
                    </ol>
                </div>
            </div>
        </div>

        {{-- Additional Help --}}
        <div class="mt-4 text-center">
            <p class="text-xs text-gray-500">
                Tidak menerima email? Periksa folder spam/junk Anda
            </p>
        </div>
    </div>
</div>
@endsection