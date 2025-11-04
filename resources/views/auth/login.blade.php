<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KSR PMI UNAUS') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased" style="background-color: #f8f9fa;">
    <div class="min-h-screen flex flex-col">
        <!-- Header Navigation -->
        <div class="w-full bg-white shadow-sm">
            <div class="max-w-6xl mx-auto px-6 py-4">
                <nav class="flex justify-between items-center">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="KSR PMI UNAUS" class="h-12 w-auto mr-3">
                        <span class="font-semibold text-gray-800">KSR PMI UNHAS</span>
                    </div>
                    
                    <!-- Navigation Menu -->
                    <div class="hidden md:flex space-x-8">
                        <a href="/" class="text-gray-700 hover:text-red-600 transition-colors">Beranda</a>
                        <a href="#" class="text-gray-700 hover:text-red-600 transition-colors">Kegiatan Donor</a>
                        <a href="#" class="text-gray-700 hover:text-red-600 transition-colors">Tentang Kami</a>
                        <a href="#" class="text-gray-700 hover:text-red-600 transition-colors">Kontak</a>
                        <a href="#" class="text-gray-700 hover:text-red-600 transition-colors">FAQ</a>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="flex space-x-4 items-center">
                        <span class="text-gray-700 font-medium">Masuk</span>
                        <a href="{{ route('register') }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors">
                            Daftar Sekarang
                        </a>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex items-center justify-center px-6 py-12">
            <div class="w-full max-w-md">
                <!-- Logo Section -->
                <div class="text-center mb-8">
                    <div class="inline-block p-4 bg-red-50 rounded-full mb-4">
                        <!-- Logo di tengah form login -->
                        <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="KSR PMI UNAUS" class="h-16 w-auto mx-auto">
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Masuk ke Akun Anda</h2>
                    <p class="text-gray-600 text-sm">Selamat datang kembali di KSR PMI UNHAS</p>
                </div>

                <!-- Login Form -->
                <div class="bg-white shadow-lg rounded-lg p-8">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input 
                                id="email" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                placeholder="mail@example.com"
                                required 
                                autofocus 
                                autocomplete="username" 
                            />
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                @if (Route::has('password.request'))
                                    <a class="text-sm text-blue-600 hover:text-blue-800 underline" href="{{ route('password.request') }}">
                                        Lupa Password?
                                    </a>
                                @endif
                            </div>
                            <input 
                                id="password" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500"
                                type="password"
                                name="password"
                                placeholder="Masukkan password"
                                required 
                                autocomplete="current-password" 
                            />
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center mb-6">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded" 
                                name="remember"
                            >
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                                Ingat saya
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-red-600 text-white py-3 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors font-medium">
                            Masuk
                        </button>

                        <!-- Register Link -->
                        <div class="text-center mt-6">
                            <span class="text-gray-600">Belum punya akun? </span>
                            <a href="{{ route('register') }}" class="text-red-600 hover:text-red-800 font-medium">
                                Daftar Sekarang
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white">
            <div class="max-w-6xl mx-auto px-6 py-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Logo and Description -->
                    <div class="col-span-1">
                        <div class="flex items-center mb-4">
                            <!-- Logo di footer -->
                            <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="KSR PMI UNAUS" class="h-8 w-auto mr-2">
                            <span class="font-semibold">KSR PMI UNHAS</span>
                        </div>
                        <p class="text-gray-300 text-sm">
                            Sistem Informasi Donor Darah KSR PMI<br>
                            Universitas Hassanuddin
                        </p>
                    </div>

                    <!-- Menu -->
                    <div class="col-span-1">
                        <h4 class="font-semibold mb-4">Menu</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="text-gray-300 hover:text-white">Beranda</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white">Kegiatan Donor</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white">Tentang Kami</a></li>
                        </ul>
                    </div>

                    <!-- Layanan -->
                    <div class="col-span-1">
                        <h4 class="font-semibold mb-4">Layanan</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="text-gray-300 hover:text-white">Daftar Menjadi Donor</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white">Formulir Permintaan Donor</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white">Informasi UTD PMI</a></li>
                        </ul>
                    </div>

                    <!-- Kontak -->
                    <div class="col-span-1">
                        <h4 class="font-semibold mb-4">Kontak</h4>
                        <div class="space-y-2 text-sm text-gray-300">
                            <p>ksr@pmi-unhas.ac.id</p>
                            <p>(041) 586010</p>
                            <p>Jl. Perintis Kemerdekaan KM.10,Makassar,Indonesia</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                    <p class="text-gray-300 text-sm">© 2025 KSR PMI UNHAS Makassar. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>