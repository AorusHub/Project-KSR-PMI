<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard Pendonor - KSR PMI UNHAS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation Header -->
        <nav class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo and Brand -->
                    <div class="flex items-center">
                        <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="KSR PMI" class="h-8 w-auto mr-3">
                        <span class="font-semibold text-xl text-gray-800">KSR PMI UNHAS</span>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700">Halo, {{ Auth::user()->nama }}!</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Welcome Section -->
                <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-6 mb-8 text-white">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold mb-2">
                                Selamat Datang, {{ $pendonor->nama_lengkap ?? Auth::user()->nama }}! 
                            </h1>
                            <p class="text-red-100">
                                Terima kasih atas dedikasi Anda dalam mendonorkan darah untuk kemanusiaan.
                            </p>
                        </div>
                        <div class="ml-6">
                            <div class="bg-white bg-opacity-20 rounded-full p-4">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Golongan Darah -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Golongan Darah</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $pendonor->golongan_darah ?? 'Belum diisi' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Kegiatan Tersedia -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Kegiatan Tersedia</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $kegiatanTersedia->count() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Donasi -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Donasi</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $riwayatDonasi->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Kegiatan Donor Tersedia -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Kegiatan Donor Terbaru</h3>
                        </div>
                        <div class="p-6">
                            @forelse($kegiatanTersedia as $kegiatan)
                                <div class="mb-4 last:mb-0 p-4 border border-gray-200 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 mb-2">
                                                {{ $kegiatan->nama_kegiatan }}
                                            </h4>
                                            <div class="space-y-1 text-sm text-gray-600">
                                                <p>📅 {{ $kegiatan->tanggal->format('d M Y, H:i') }}</p>
                                                <p>📍 {{ $kegiatan->lokasi }}</p>
                                                <p>🎯 Target: {{ $kegiatan->target_donor }} pendonor</p>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $kegiatan->status }}
                                        </span>
                                    </div>
                                    <div class="mt-3">
                                        <button class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition-colors text-sm font-medium">
                                            Daftar Kegiatan
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-gray-500">Tidak ada kegiatan tersedia saat ini</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Riwayat Donasi -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Riwayat Donasi Saya</h3>
                        </div>
                        <div class="p-6">
                            @forelse($riwayatDonasi as $donasi)
                                <div class="mb-4 last:mb-0 p-4 border border-gray-200 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 mb-2">
                                                {{ $donasi->jenis_donor }}
                                            </h4>
                                            <div class="space-y-1 text-sm text-gray-600">
                                                <p>📅 {{ $donasi->tgl_donasi->format('d M Y') }}</p>
                                                <p>📍 {{ $donasi->lokasi_donor }}</p>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $donasi->status_donasi == 'Selesai' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $donasi->status_donasi }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path>
                                    </svg>
                                    <p class="text-gray-500">Belum ada riwayat donasi</p>
                                    <p class="text-sm text-gray-400 mt-1">Ayo mulai berdonor untuk membantu sesama!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Pendaftaran Saya -->
                @if($pendaftaranSaya->count() > 0)
                <div class="mt-8">
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Pendaftaran Kegiatan Saya</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($pendaftaranSaya as $pendaftaran)
                                    <div class="p-4 border border-gray-200 rounded-lg">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-semibold text-gray-900">
                                                {{ $pendaftaran->kegiatan->nama_kegiatan }}
                                            </h4>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $pendaftaran->status_pendaftaran == 'Diterima' ? 'bg-green-100 text-green-800' : 
                                                   ($pendaftaran->status_pendaftaran == 'Pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ $pendaftaran->status_pendaftaran }}
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            <p>📅 {{ $pendaftaran->kegiatan->tanggal->format('d M Y') }}</p>
                                            <p>📍 {{ $pendaftaran->kegiatan->lokasi }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Info Kesehatan -->
                <div class="mt-8">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Info Kesehatan Donor</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Pastikan kondisi tubuh sehat sebelum donor</li>
                                        <li>Jarak minimal antar donor darah adalah 12 minggu (3 bulan)</li>
                                        <li>Makan dan minum yang cukup sebelum donor</li>
                                        <li>Istirahat yang cukup setelah donor darah</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>