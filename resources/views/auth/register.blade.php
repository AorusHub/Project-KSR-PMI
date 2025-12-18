@extends('layouts.guest')

@section('title', 'Daftar - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-8 sm:py-12 px-4 sm:px-6 lg:px-8 transition-colors">
    <div class="max-w-lg w-full">
        {{-- Header --}}
        <div class="text-center mb-6 sm:mb-8">
            <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="Logo KSR PMI" class="mx-auto h-14 w-14 sm:h-16 sm:w-16 object-contain mb-3 sm:mb-4" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2264%22 height=%2264%22 viewBox=%220 0 64 64%22%3E%3Ccircle cx=%2232%22 cy=%2232%22 r=%2232%22 fill=%22%23dc2626%22/%3E%3Cpath d=%22M32 12 L38 28 L54 28 L42 38 L46 54 L32 45 L18 54 L22 38 L10 28 L26 28 Z%22 fill=%22white%22/%3E%3C/svg%3E'">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white transition-colors">
                Daftar Sebagai Pendonor
            </h2>
            <p class="mt-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400 transition-colors">
                Bergabunglah dengan ribuan pendonor KSR PMI UNHAS
            </p>
        </div>

        {{-- Register Form Card --}}
        <div class="bg-white dark:bg-gray-800 shadow-md dark:shadow-gray-900/50 rounded-lg border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors">
            <form action="{{ route('register') }}" method="POST" class="p-4 sm:p-6 space-y-4 sm:space-y-5">
                @csrf

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-400 px-3 sm:px-4 py-2.5 sm:py-3 rounded text-xs sm:text-sm transition-colors">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Data Pribadi Section --}}
                <div>
                    <h3 class="text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 sm:mb-4 transition-colors">Data Pribadi</h3>
                    
                    {{-- Nama Lengkap --}}
                    <div class="mb-3 sm:mb-4">
                        <label for="nama" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors">
                            Nama Lengkap <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <input 
                            id="nama" 
                            name="nama" 
                            type="text" 
                            required 
                            value="{{ old('nama') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400 placeholder-gray-400 dark:placeholder-gray-500 transition-colors"
                            placeholder="Nama sesuai KTP"
                        >
                    </div>

                    {{-- Grid 2 Columns: NIK & Tanggal Lahir --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-3 sm:mb-4">
                        <div>
                            <label for="nik" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors">
                                NIK (opsional)
                            </label>
                            <input 
                                id="nik" 
                                name="nik" 
                                type="text" 
                                value="{{ old('nik') }}"
                                maxlength="16"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400 placeholder-gray-400 dark:placeholder-gray-500 transition-colors"
                                placeholder="16 digit NIK"
                            >
                        </div>

                        <div>
                            <label for="tanggal_lahir" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors">
                                Tanggal Lahir <span class="text-red-500 dark:text-red-400">*</span>
                            </label>
                            <input 
                                id="tanggal_lahir" 
                                name="tanggal_lahir" 
                                type="date" 
                                required 
                                value="{{ old('tanggal_lahir') }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400 transition-colors"
                            >
                        </div>
                    </div>

                    {{-- Grid 2 Columns: Jenis Kelamin & Golongan Darah --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-3 sm:mb-4">
                        <div>
                            <label for="jenis_kelamin" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors">
                                Jenis Kelamin <span class="text-red-500 dark:text-red-400">*</span>
                            </label>
                            <select 
                                id="jenis_kelamin" 
                                name="jenis_kelamin" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400 transition-colors"
                            >
                                <option value="" class="dark:bg-gray-700">Pilih jenis kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }} class="dark:bg-gray-700">Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }} class="dark:bg-gray-700">Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label for="golongan_darah" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors">
                                Golongan Darah <span class="text-red-500 dark:text-red-400">*</span>
                            </label>
                            <select 
                                id="golongan_darah" 
                                name="golongan_darah" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400 transition-colors"
                            >
                                <option value="" class="dark:bg-gray-700">Pilih golongan darah</option>
                                <option value="A+" {{ old('golongan_darah') == 'A+' ? 'selected' : '' }} class="dark:bg-gray-700">A+</option>
                                <option value="A-" {{ old('golongan_darah') == 'A-' ? 'selected' : '' }} class="dark:bg-gray-700">A-</option>
                                <option value="B+" {{ old('golongan_darah') == 'B+' ? 'selected' : '' }} class="dark:bg-gray-700">B+</option>
                                <option value="B-" {{ old('golongan_darah') == 'B-' ? 'selected' : '' }} class="dark:bg-gray-700">B-</option>
                                <option value="AB+" {{ old('golongan_darah') == 'AB+' ? 'selected' : '' }} class="dark:bg-gray-700">AB+</option>
                                <option value="AB-" {{ old('golongan_darah') == 'AB-' ? 'selected' : '' }} class="dark:bg-gray-700">AB-</option>
                                <option value="O+" {{ old('golongan_darah') == 'O+' ? 'selected' : '' }} class="dark:bg-gray-700">O+</option>
                                <option value="O-" {{ old('golongan_darah') == 'O-' ? 'selected' : '' }} class="dark:bg-gray-700">O-</option>
                            </select>
                        </div>
                    </div>

                    {{-- Berat Badan --}}
                    <div class="mb-3 sm:mb-4">
                        <label for="berat_badan" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors">
                            Berat Badan (kg) <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <input 
                            id="berat_badan" 
                            name="berat_badan" 
                            type="number" 
                            step="0.1"
                            required 
                            value="{{ old('berat_badan') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400 placeholder-gray-400 dark:placeholder-gray-500 transition-colors"
                            placeholder="Contoh: 55"
                        >
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label for="alamat" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors">
                            Alamat (opsional)
                        </label>
                        <textarea 
                            id="alamat" 
                            name="alamat" 
                            rows="2"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400 placeholder-gray-400 dark:placeholder-gray-500 resize-none transition-colors"
                            placeholder="Alamat lengkap"
                        >{{ old('alamat') }}</textarea>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-gray-200 dark:border-gray-700 my-4 sm:my-5 transition-colors"></div>

                {{-- Kontak & Akun Section --}}
                <div>
                    <h3 class="text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 sm:mb-4 transition-colors">Kontak & Akun</h3>
                    
                    {{-- Grid 2 Columns: No HP & Email --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-3 sm:mb-4">
                        <div>
                            <label for="no_telepon" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors">
                                No. HP <span class="text-red-500 dark:text-red-400">*</span>
                            </label>
                            <input 
                                id="no_telepon" 
                                name="no_telepon" 
                                type="tel" 
                                required 
                                value="{{ old('no_telepon') }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400 placeholder-gray-400 dark:placeholder-gray-500 transition-colors"
                                placeholder="08xxxxxxxxxx"
                            >
                        </div>

                        <div>
                            <label for="email" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors">
                                Email <span class="text-red-500 dark:text-red-400">*</span>
                            </label>
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                required 
                                value="{{ old('email') }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400 placeholder-gray-400 dark:placeholder-gray-500 transition-colors"
                                placeholder="email@example.com"
                            >
                        </div>
                    </div>

                    {{-- Grid 2 Columns: Password & Konfirmasi --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label for="password" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors">
                                Password <span class="text-red-500 dark:text-red-400">*</span>
                            </label>
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400 placeholder-gray-400 dark:placeholder-gray-500 transition-colors"
                                placeholder="Minimal 8 karakter"
                            >
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 transition-colors">
                                Konfirmasi Password <span class="text-red-500 dark:text-red-400">*</span>
                            </label>
                            <input 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                type="password" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400 placeholder-gray-400 dark:placeholder-gray-500 transition-colors"
                                placeholder="Ulangi password"
                            >
                        </div>
                    </div>
                </div>

                {{-- Terms Checkbox --}}
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md p-2.5 sm:p-3 transition-colors">
                    <div class="flex items-start">
                        <input 
                            id="terms" 
                            name="terms" 
                            type="checkbox" 
                            required
                            class="mt-0.5 sm:mt-1 h-4 w-4 text-red-600 dark:text-red-500 focus:ring-red-500 dark:focus:ring-red-400 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded transition-colors"
                        >
                        <label for="terms" class="ml-2 text-[10px] sm:text-xs text-gray-700 dark:text-gray-300 leading-relaxed transition-colors">
                            Dengan mendaftar, Anda menyetujui untuk menjadi pendonor sukarela dan data Anda akan digunakan untuk keperluan kegiatan donor darah KSR PMI UNHAS.
                        </label>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button 
                    type="submit"
                    class="w-full bg-red-600 dark:bg-red-600 hover:bg-red-700 dark:hover:bg-red-700 text-white font-semibold py-2 sm:py-2.5 px-4 rounded-md transition-all focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 text-sm sm:text-base transform active:scale-95"
                >
                    Daftar Sekarang
                </button>
            </form>
        </div>

        {{-- Footer Link --}}
        <div class="text-center mt-4 sm:mt-6">
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 transition-colors">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors">
                    Masuk di sini
                </a>
            </p>
        </div>
    </div>
</div>
@endsection