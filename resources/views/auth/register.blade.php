{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\auth\register.blade.php --}}
@extends('layouts.guest')

@section('title', 'Daftar - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-8">
        {{-- Header --}}
        <div class="text-center">
            <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="Logo KSR PMI" class="mx-auto h-20 w-20 object-contain" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2280%22 height=%2280%22 viewBox=%220 0 80 80%22%3E%3Ccircle cx=%2240%22 cy=%2240%22 r=%2240%22 fill=%22%23dc2626%22/%3E%3Cpath d=%22M40 16 L46 36 L66 36 L50 50 L56 70 L40 57 L24 70 L30 50 L14 36 L34 36 Z%22 fill=%22white%22/%3E%3C/svg%3E'">
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                Daftar Sebagai Pendonor
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-red-600 hover:text-red-500">
                    Masuk di sini
                </a>
            </p>
        </div>

        {{-- Register Form --}}
        <div class="bg-white py-8 px-6 shadow-lg rounded-lg sm:px-10">
            <form class="space-y-6" action="{{ route('register') }}" method="POST">
                @csrf

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

                {{-- Grid 2 Columns --}}
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    {{-- Nama Lengkap --}}
                    <div class="sm:col-span-2">
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="nama" 
                            name="nama" 
                            type="text" 
                            required 
                            value="{{ old('nama') }}"
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                            placeholder="Contoh: Ahmad Rizki"
                        >
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            required 
                            value="{{ old('email') }}"
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                            placeholder="nama@email.com"
                        >
                    </div>

                    {{-- No Telepon --}}
                    <div>
                        <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-2">
                            No. Telepon <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="no_telepon" 
                            name="no_telepon" 
                            type="tel" 
                            required 
                            value="{{ old('no_telepon') }}"
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                            placeholder="08xxxxxxxxxx"
                        >
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Lahir <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="tanggal_lahir" 
                            name="tanggal_lahir" 
                            type="date" 
                            required 
                            value="{{ old('tanggal_lahir') }}"
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                        >
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="jenis_kelamin" 
                            name="jenis_kelamin" 
                            required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                        >
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    {{-- Golongan Darah --}}
                    <div>
                        <label for="golongan_darah" class="block text-sm font-medium text-gray-700 mb-2">
                            Golongan Darah <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="golongan_darah" 
                            name="golongan_darah" 
                            required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                        >
                            <option value="">Pilih Golongan Darah</option>
                            <option value="A+" {{ old('golongan_darah') == 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ old('golongan_darah') == 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ old('golongan_darah') == 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ old('golongan_darah') == 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ old('golongan_darah') == 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ old('golongan_darah') == 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ old('golongan_darah') == 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ old('golongan_darah') == 'O-' ? 'selected' : '' }}>O-</option>
                        </select>
                    </div>

                    {{-- Berat Badan --}}
                    <div>
                        <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2">
                            Berat Badan (kg) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="berat_badan" 
                            name="berat_badan" 
                            type="number" 
                            required 
                            value="{{ old('berat_badan') }}"
                            min="1"
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                            placeholder="Contoh: 55"
                        >
                    </div>

                    {{-- Alamat --}}
                    <div class="sm:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="alamat" 
                            name="alamat" 
                            rows="3" 
                            required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors resize-none"
                            placeholder="Alamat lengkap"
                        >{{ old('alamat') }}</textarea>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                            placeholder="Minimal 8 karakter"
                        >
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            type="password" 
                            required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                            placeholder="Ulangi password"
                        >
                    </div>
                </div>

                {{-- Terms & Conditions --}}
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input 
                            id="terms" 
                            name="terms" 
                            type="checkbox" 
                            required
                            class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded cursor-pointer"
                        >
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="font-medium text-gray-700 cursor-pointer">
                            Saya setuju dengan <a href="#" class="text-red-600 hover:text-red-500">Syarat & Ketentuan</a> dan <a href="#" class="text-red-600 hover:text-red-500">Kebijakan Privasi</a>
                        </label>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div>
                    <button 
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-semibold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                    >
                        Daftar Sekarang
                    </button>
                </div>
            </form>

            {{-- Back to Home --}}
            <div class="mt-6">
                <a 
                    href="{{ route('home') }}"
                    class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                >
                    Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </div>
</div>
@endsection