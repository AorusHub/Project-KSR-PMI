@extends('layouts.guest')

@section('title', 'Daftar - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full">
        {{-- Header --}}
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="Logo KSR PMI" class="mx-auto h-16 w-16 object-contain mb-4" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2264%22 height=%2264%22 viewBox=%220 0 64 64%22%3E%3Ccircle cx=%2232%22 cy=%2232%22 r=%2232%22 fill=%22%23dc2626%22/%3E%3Cpath d=%22M32 12 L38 28 L54 28 L42 38 L46 54 L32 45 L18 54 L22 38 L10 28 L26 28 Z%22 fill=%22white%22/%3E%3C/svg%3E'">
            <h2 class="text-2xl font-bold text-gray-900">
                Daftar Sebagai Pendonor
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Bergabunglah dengan ribuan pendonor KSR PMI UNHAS
            </p>
        </div>

        {{-- Register Form Card --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <form action="{{ route('register') }}" method="POST" class="p-6 space-y-5">
                @csrf

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Data Pribadi Section --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Data Pribadi</h3>
                    
                    {{-- Nama Lengkap --}}
                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="nama" 
                            name="nama" 
                            type="text" 
                            required 
                            value="{{ old('nama') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500"
                            placeholder="Nama sesuai KTP"
                        >
                    </div>

                    {{-- Grid 2 Columns: NIK & Tanggal Lahir --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">
                                NIK (opsional)
                            </label>
                            <input 
                                id="nik" 
                                name="nik" 
                                type="text" 
                                value="{{ old('nik') }}"
                                maxlength="16"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500"
                                placeholder="16 digit NIK"
                            >
                        </div>

                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <input 
                                id="tanggal_lahir" 
                                name="tanggal_lahir" 
                                type="date" 
                                required 
                                value="{{ old('tanggal_lahir') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500"
                            >
                        </div>
                    </div>

                    {{-- Grid 2 Columns: Jenis Kelamin & Golongan Darah --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="jenis_kelamin" 
                                name="jenis_kelamin" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500"
                            >
                                <option value="">Pilih jenis kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label for="golongan_darah" class="block text-sm font-medium text-gray-700 mb-1">
                                Golongan Darah <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="golongan_darah" 
                                name="golongan_darah" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500"
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
                        </div>
                    </div>

                    {{-- Berat Badan --}}
                    <div class="mb-4">
                        <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-1">
                            Berat Badan (kg) <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="berat_badan" 
                            name="berat_badan" 
                            type="number" 
                            step="0.1"
                            required 
                            value="{{ old('berat_badan') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500"
                            placeholder="Contoh: 55"
                        >
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                            Alamat (opsional)
                        </label>
                        <textarea 
                            id="alamat" 
                            name="alamat" 
                            rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500 resize-none"
                            placeholder="Alamat lengkap"
                        >{{ old('alamat') }}</textarea>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-gray-200 my-5"></div>

                {{-- Kontak & Akun Section --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Kontak & Akun</h3>
                    
                    {{-- Grid 2 Columns: No HP & Email --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1">
                                No. HP <span class="text-red-500">*</span>
                            </label>
                            <input 
                                id="no_telepon" 
                                name="no_telepon" 
                                type="tel" 
                                required 
                                value="{{ old('no_telepon') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500"
                                placeholder="08xxxxxxxxxx"
                            >
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                required 
                                value="{{ old('email') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500"
                                placeholder="email@example.com"
                            >
                        </div>
                    </div>

                    {{-- Grid 2 Columns: Password & Konfirmasi --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500"
                                placeholder="Minimal 8 karakter"
                            >
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                Konfirmasi Password <span class="text-red-500">*</span>
                            </label>
                            <input 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                type="password" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500"
                                placeholder="Ulangi password"
                            >
                        </div>
                    </div>
                </div>

                {{-- Terms Checkbox --}}
                <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                    <div class="flex items-start">
                        <input 
                            id="terms" 
                            name="terms" 
                            type="checkbox" 
                            required
                            class="mt-1 h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded"
                        >
                        <label for="terms" class="ml-2 text-xs text-gray-700 leading-relaxed">
                            Dengan mendaftar, Anda menyetujui untuk menjadi pendonor sukarela dan data Anda akan digunakan untuk keperluan kegiatan donor darah KSR PMI UNHAS.
                        </label>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button 
                    type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 px-4 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                >
                    Daftar Sekarang
                </button>
            </form>
        </div>

        {{-- Footer Link --}}
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-red-600 hover:text-red-700">
                    Masuk di sini
                </a>
            </p>
        </div>
    </div>
</div>
@endsection