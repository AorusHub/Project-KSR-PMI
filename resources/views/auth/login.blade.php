{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\auth\login.blade.php --}}
@extends('layouts.guest')

@section('title', 'Login - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8 transition-colors">
    <div class="max-w-md w-full space-y-6 sm:space-y-8">
        {{-- Header --}}
        <div class="text-center">
            <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="Logo KSR PMI" class="mx-auto h-16 w-16 sm:h-20 sm:w-20 object-contain" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2280%22 height=%2280%22 viewBox=%220 0 80 80%22%3E%3Ccircle cx=%2240%22 cy=%2240%22 r=%2240%22 fill=%22%23dc2626%22/%3E%3Cpath d=%22M40 16 L46 36 L66 36 L50 50 L56 70 L40 57 L24 70 L30 50 L14 36 L34 36 Z%22 fill=%22white%22/%3E%3C/svg%3E'">
            <h2 class="mt-4 sm:mt-6 text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white transition-colors">
                Masuk ke Akun Anda
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 transition-colors">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-medium text-red-600 dark:text-red-400 hover:text-red-500 dark:hover:text-red-300 transition-colors">
                    Daftar sekarang
                </a>
            </p>
        </div>

        {{-- Login Form --}}
        <div class="bg-white dark:bg-gray-800 py-6 sm:py-8 px-4 sm:px-6 lg:px-10 shadow-lg dark:shadow-gray-900/50 rounded-lg border border-gray-100 dark:border-gray-700 transition-colors">
            <form class="space-y-5 sm:space-y-6" action="{{ route('login') }}" method="POST">
                @csrf

                {{-- Success Messages --}}
                @if (session('success'))
                    <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-600 dark:text-green-400 px-4 py-3 rounded-lg text-sm transition-colors">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-red-600 dark:text-red-400 px-4 py-3 rounded-lg text-sm transition-colors">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 transition-colors">
                        Email
                    </label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        autocomplete="email" 
                        required 
                        value="{{ old('email') }}"
                        class="appearance-none block w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-transparent transition-colors text-sm sm:text-base"
                        placeholder="nama@email.com"
                    >
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 transition-colors">
                            Password
                        </label>
                        <a href="{{ route('password.request') }}" class="text-xs sm:text-sm font-medium text-red-600 dark:text-red-400 hover:text-red-500 dark:hover:text-red-300 transition-colors">
                            Lupa password?
                        </a>
                    </div>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        autocomplete="current-password" 
                        required
                        class="appearance-none block w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg shadow-sm placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-transparent transition-colors text-sm sm:text-base"
                        placeholder="••••••••"
                    >
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            id="remember_me" 
                            name="remember" 
                            type="checkbox"
                            class="h-4 w-4 text-red-600 dark:text-red-500 focus:ring-red-500 dark:focus:ring-red-400 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded cursor-pointer transition-colors"
                        >
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300 cursor-pointer transition-colors">
                            Ingat saya
                        </label>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div>
                    <button 
                        type="submit"
                        class="w-full flex justify-center py-2.5 sm:py-3 px-4 border border-transparent rounded-lg shadow-md text-sm sm:text-base font-semibold text-white bg-red-600 dark:bg-red-600 hover:bg-red-700 dark:hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 focus:ring-red-500 dark:focus:ring-red-400 transition-all transform active:scale-95"
                    >
                        Masuk
                    </button>
                </div>
            </form>
        </div>

        {{-- Additional Info - Optional --}}
        <p class="text-center text-xs sm:text-sm text-gray-500 dark:text-gray-400 transition-colors">
            Dengan masuk, Anda menyetujui 
            <a href="#" class="text-red-600 dark:text-red-400 hover:text-red-500 dark:hover:text-red-300 transition-colors">Syarat & Ketentuan</a>
        </p>
    </div>
</div>
@endsection