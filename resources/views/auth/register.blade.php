<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KSR PMI UNAUS') }} - Daftar</title>

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
                        <span class="font-semibold text-gray-800">KSR PMI UNAUS</span>
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
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-red-600 transition-colors font-medium">Masuk</a>
                        <span class="bg-red-600 text-white px-4 py-2 rounded-md">Daftar Sekarang</span>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex items-center justify-center px-6 py-12">
            <div class="w-full max-w-4xl">
                <!-- Header Section -->
                <div class="text-center mb-8">
                    <div class="inline-block p-4 bg-red-50 rounded-full mb-4">
                        <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="KSR PMI UNAUS" class="h-16 w-auto mx-auto">
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Daftar Sebagai Pendonor</h2>
                    <p class="text-gray-600 text-sm">Bergabunglah dengan komunitas pendonor KSR PMI UNAUS</p>
                </div>

                <!-- Registration Form -->
                <div class="bg-white shadow-lg rounded-lg p-8">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Lengkap -->
                            <div class="md:col-span-2">
                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                <input 
                                    id="nama" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500" 
                                    type="text" 
                                    name="nama" 
                                    value="{{ old('nama') }}" 
                                    placeholder="Masukkan nama lengkap"
                                    required 
                                />
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NIK -->
                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK (Nomor Induk Kependudukan) *</label>
                                <input 
                                    id="nik" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500" 
                                    type="text" 
                                    name="nik" 
                                    value="{{ old('nik') }}" 
                                    placeholder="Contoh: 3201234567890123"
                                    maxlength="16"
                                    required 
                                />
                                @error('nik')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tempat Lahir -->
                            <div>
                                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tempat Lahir *</label>
                                <input 
                                    id="tempat_lahir" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500" 
                                    type="text" 
                                    name="tempat_lahir" 
                                    value="{{ old('tempat_lahir') }}" 
                                    placeholder="Contoh: Jakarta"
                                    required 
                                />
                                @error('tempat_lahir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <label for="tgl_lahir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Lahir *</label>
                                <input 
                                    id="tgl_lahir" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500" 
                                    type="date" 
                                    name="tgl_lahir" 
                                    value="{{ old('tgl_lahir') }}" 
                                    required 
                                />
                                @error('tgl_lahir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin *</label>
                                <select 
                                    id="jenis_kelamin" 
                                    name="jenis_kelamin" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                                    required
                                >
                                    <option value="">Pilih jenis kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alamat -->
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap *</label>
                                <textarea 
                                    id="alamat" 
                                    name="alamat" 
                                    rows="3"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500" 
                                    placeholder="Masukkan alamat lengkap"
                                    required 
                                >{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Golongan Darah -->
                            <div>
                                <label for="golongan_darah" class="block text-sm font-medium text-gray-700 mb-2">Golongan Darah *</label>
                                <select 
                                    id="golongan_darah" 
                                    name="golongan_darah" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                                    required
                                >
                                    <option value="">Pilih golongan darah</option>
                                    <option value="A+" {{ old('golongan_darah') == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A-" {{ old('golongan_darah') == 'A-' ? 'selected' : '' }}>A-</option>
                                    <option value="B+" {{ old('golongan_darah') == 'B+' ? 'selected' : '' }}>B+</option>
                                    <option value="B-" {{ old('golongan_darah') == 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="AB+" {{ old('golongan_darah') == 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('golongan_darah') == 'AB-' ? 'selected' : '' }}>AB-</option>
                                    <option value="O+" {{ old('golongan_darah') == 'O+' ? 'selected' : '' }}>O+</option>
                                    <option value="O-" {{ old('golongan_darah') == 'O-' ? 'selected' : '' }}>O-</option>
                                </select>
                                @error('golongan_darah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No. HP -->
                            <div>
                                <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">No. HP *</label>
                                <input 
                                    id="no_hp" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500" 
                                    type="tel" 
                                    name="no_hp" 
                                    value="{{ old('no_hp') }}" 
                                    placeholder="Contoh: 081234567890"
                                    required 
                                />
                                @error('no_hp')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input 
                                    id="email" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500" 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    placeholder="contoh@email.com"
                                    required 
                                />
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Konfirmasi Email -->
                            <div>
                                <label for="email_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Email *</label>
                                <input 
                                    id="email_confirmation" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500" 
                                    type="email" 
                                    name="email_confirmation" 
                                    value="{{ old('email_confirmation') }}" 
                                    placeholder="Ulangi email"
                                    required 
                                />
                                @error('email_confirmation')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                                <input 
                                    id="password" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500"
                                    type="password"
                                    name="password"
                                    placeholder="Minimal 8 karakter"
                                    required 
                                />
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password *</label>
                                <input 
                                    id="password_confirmation" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500"
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Ulangi password"
                                    required 
                                />
                                @error('password_confirmation')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mt-6">
                            <div class="flex items-start">
                                <input 
                                    id="terms" 
                                    type="checkbox" 
                                    class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded mt-1" 
                                    name="terms"
                                    required
                                >
                                <label for="terms" class="ml-2 block text-sm text-gray-700">
                                    Dengan mendaftar, saya menyetujui <a href="#" class="text-red-600 hover:text-red-800 underline">syarat dan ketentuan</a> yang berlaku dan bersedia mengikuti aturan donor darah KSR PMI UNAUS.
                                </label>
                            </div>
                            @error('terms')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8">
                            <button type="submit" class="w-full bg-red-600 text-white py-3 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors font-medium">
                                Daftar Sekarang
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center mt-6">
                            <span class="text-gray-600">Sudah punya akun? </span>
                            <a href="{{ route('login') }}" class="text-red-600 hover:text-red-800 font-medium">
                                Masuk di sini
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
                            <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="KSR PMI UNAUS" class="h-8 w-auto mr-2">
                            <span class="font-semibold">KSR PMI UNAUS</span>
                        </div>
                        <p class="text-gray-300 text-sm">
                            Sistem Informasi Donor Darah KSR PMI<br>
                            Universitas Kristen Maranatha
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
                            <p>Email: info@ksrpmi-unaus.ac.id</p>
                            <p>Telp: (0361) 555-0123</p>
                            <p>Alamat: Jl. Surya Sumantri No.65<br>Bandung, Kemanggisan, DKI Jkt<br>Indonesia</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                    <p class="text-gray-300 text-sm">© 2024 KSR PMI UNAUS Maranatha. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>