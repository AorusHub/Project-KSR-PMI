{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\auth\login.blade.php --}}
@extends('layouts.guest')

@section('title', 'Login - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        {{-- Header --}}
        <div class="text-center">
            <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="Logo KSR PMI" class="mx-auto h-20 w-20 object-contain" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2280%22 height=%2280%22 viewBox=%220 0 80 80%22%3E%3Ccircle cx=%2240%22 cy=%2240%22 r=%2240%22 fill=%22%23dc2626%22/%3E%3Cpath d=%22M40 16 L46 36 L66 36 L50 50 L56 70 L40 57 L24 70 L30 50 L14 36 L34 36 Z%22 fill=%22white%22/%3E%3C/svg%3E'">
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                Masuk ke Akun Anda
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-medium text-red-600 hover:text-red-500">
                    Daftar sekarang
                </a>
            </p>
        </div>

        {{-- Login Form --}}
        <div class="bg-white py-8 px-6 shadow-lg rounded-lg sm:px-10">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf

                {{-- Success Messages --}}
                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        autocomplete="email" 
                        required 
                        value="{{ old('email') }}"
                        class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                        placeholder="nama@email.com"
                    >
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-medium text-red-600 hover:text-red-500">
                                Lupa password?
                            </a>
                        </div>
                    </div>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        autocomplete="current-password" 
                        required
                        class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
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
                            class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded cursor-pointer"
                        >
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700 cursor-pointer">
                            Ingat saya
                        </label>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div>
                    <button 
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                    >
                        Masuk
                    </button>
                </div>
            </form>


        </div>
    </div>
</div>
@endsection