{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\home.blade.php --}}
@extends('layouts.guest')

@section('title', 'Beranda - KSR PMI UNHAS')

@section('content')
    {{-- Hero Section --}}
     <section class="bg-gradient-to-br from-red-600 via-red-700 to-red-800 text-white py-20 relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-left max-w-2xl space-y-6">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                    Setetes Darah Anda,<br>
                    Nyawa Bagi Sesama
                </h1>
                <p class="text-lg md:text-xl text-red-50">
                    Bergabunglah dengan ribuan pendonor sukarela KSR PMI UNHAS<br>
                    Makassar dan selamatkan nyawa hari ini.
                </p>
                <div class="flex flex-wrap gap-4 pt-4">
                    @auth
                        @if(Auth::user()->role === 'pendonor')
                            <a href="{{ route('kegiatan.index') }}" class="px-6 py-3 bg-white text-red-600 font-semibold rounded-lg hover:bg-gray-100 transition-all shadow-lg">
                                Cari Kegiatan Donor
                            </a>
                            <a href="{{ route('pendonor.permintaan-darah.create') }}" class="px-6 py-3 bg-transparent border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-red-600 transition-all">
                                Butuh Darah Cepat?
                            </a>
                            <a href="#kegiatan" class="px-6 py-3 bg-white text-red-600 font-semibold rounded-lg hover:bg-gray-100 transition-all shadow-lg">
                                Lihat Donor Darurat
                            </a>
                        @elseif(!in_array(Auth::user()->role, ['admin', 'staf']))
                            <a href="{{ route('kegiatan.index') }}" class="px-6 py-3 bg-white text-red-600 font-semibold rounded-lg hover:bg-gray-100 transition-all shadow-lg">
                                Cari Kegiatan Donor
                            </a>
                            <a href="{{ route('login') }}" class="px-6 py-3 bg-transparent border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-red-600 transition-all">
                                Butuh Darah Cepat?
                            </a>
                            <a href="#kegiatan" class="px-6 py-3 bg-white text-red-600 font-semibold rounded-lg hover:bg-gray-100 transition-all shadow-lg">
                                Lihat Donor Darurat
                            </a>
                        @endif
                    @else
                        <a href="{{ route('kegiatan.index') }}" class="px-6 py-3 bg-white text-red-600 font-semibold rounded-lg hover:bg-gray-100 transition-all shadow-lg">
                            Cari Kegiatan Donor
                        </a>
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-transparent border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-red-600 transition-all">
                            Butuh Darah Cepat?
                        </a>
                        <a href="#kegiatan" class="px-6 py-3 bg-white text-red-600 font-semibold rounded-lg hover:bg-gray-100 transition-all shadow-lg">
                            Lihat Donor Darurat
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Stat 1 - Total Pendonor --}}
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow p-8 text-center">
                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-4xl font-bold text-red-600 mb-2">{{ $totalPendonor ?? '5,247' }}</h3>
                    <p class="text-sm text-gray-600 font-medium">Total Pendonor Terdaftar</p>
                </div>

                {{-- Stat 2 - Kantong Darah --}}
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow p-8 text-center">
                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <h3 class="text-4xl font-bold text-red-600 mb-2">{{ $totalDonasi ?? '12,438' }}</h3>
                    <p class="text-sm text-gray-600 font-medium">Kantong Darah Terkumpul</p>
                </div>

                {{-- Stat 3 - Kegiatan --}}
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow p-8 text-center">
                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-4xl font-bold text-red-600 mb-2">{{ $totalKegiatan ?? '48' }}</h3>
                    <p class="text-sm text-gray-600 font-medium">Kegiatan Selesai Tahun Ini</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Kegiatan Donor Terdekat Section --}}
    <section id="kegiatan" class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Kegiatan Donor Terdekat</h2>
                <p class="text-sm text-gray-600">Daftar sekarang dan jadilah pahlawan bagi mereka yang membutuhkan</p>
            </div>

            {{-- Conditional Grid: jika hanya 1 kegiatan, center alignment --}}
            <div class="grid grid-cols-1 md:grid-cols-{{ $kegiatanTerdekat && count($kegiatanTerdekat) == 1 ? '1' : '3' }} gap-6 {{ $kegiatanTerdekat && count($kegiatanTerdekat) == 1 ? 'max-w-md mx-auto' : '' }}">
                @forelse($kegiatanTerdekat ?? [] as $kegiatan)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all">
                    <div class="relative h-48">
                        <img src="{{ asset('images/donor-' . $loop->iteration . '.jpg') }}" alt="Donor Darah" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/400x300/dc2626/ffffff?text=Donor+Darah'">
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-base text-gray-800 mb-3">{{ $kegiatan->nama_kegiatan }}</h3>
                        <div class="space-y-2 text-xs text-gray-600 mb-4">
                            <p class="flex items-start">
                                <svg class="w-4 h-4 mr-2 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d F Y') }} / {{ $kegiatan->waktu_mulai }} - {{ $kegiatan->waktu_selesai }} WITA</span>
                            </p>
                            <p class="flex items-start">
                                <svg class="w-4 h-4 mr-2 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ $kegiatan->lokasi }}</span>
                            </p>
                        </div>
                        <a href="{{ route('kegiatan.show', $kegiatan->kegiatan_id) }}" class="block w-full text-center bg-red-600 text-white text-sm font-semibold py-2.5 rounded-lg hover:bg-red-700 transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @empty
                {{-- Default cards --}}
                @for($i = 1; $i <= 3; $i++)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all">
                    <div class="relative h-48">
                        <img src="{{ asset('images/donor-' . $i . '.jpg') }}" alt="Donor Darah" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/400x300/dc2626/ffffff?text=Donor+Darah'">
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-base text-gray-800 mb-3">
                            @if($i == 1) Donor Darah Kampus UNHAS
                            @elseif($i == 2) Donor Darah Menjaga Raya Makassar
                            @else Donor Darah Mall Panakkukang
                            @endif
                        </h3>
                        <div class="space-y-2 text-xs text-gray-600 mb-4">
                            <p class="flex items-start">
                                <svg class="w-4 h-4 mr-2 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>
                                    @if($i == 1) 15 November 2024 / 08:00 - 16:00 WITA
                                    @elseif($i == 2) 20 November 2024 / 09:00 - 15:00 WITA
                                    @else 25 November 2024 / 10:00 - 14:00 WITA
                                    @endif
                                </span>
                            </p>
                            <p class="flex items-start">
                                <svg class="w-4 h-4 mr-2 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>
                                    @if($i == 1) Gedung Andi Pangerang UNHAS, Tamalanrea
                                    @elseif($i == 2) Jl. Abdullah Daeng Sirua, A. Posi Makassar
                                    @else Mall Panakkukang, Jl. Boulevard, Makassar
                                    @endif
                                </span>
                            </p>
                        </div>
                        <a href="{{ route('kegiatan.index') }}" class="block w-full text-center bg-red-600 text-white text-sm font-semibold py-2.5 rounded-lg hover:bg-red-700 transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @endfor
                @endforelse
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('kegiatan.index') }}" class="inline-block px-6 py-2.5 border-2 border-red-600 text-red-600 text-sm font-semibold rounded-lg hover:bg-red-600 hover:text-white transition-all">
                    Lihat Semua Kegiatan
                </a>
            </div>
        </div>
    </section>
   

    {{-- Bagaimana Cara Kegiatan Section --}}
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Bagaimana Cara Kegiatan?</h2>
            </div>

            {{-- Red Process Section --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                {{-- Step 1 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold shadow-lg">
                        1
                    </div>
                    <h3 class="font-bold text-base text-gray-800 mb-2">Daftar & Isi Kegiatan</h3>
                    <p class="text-sm text-gray-600">
                        Buat akun dan pilih formulir donor dengan detail yang lengkap dan akurat sebagai langkah Anda
                    </p>
                </div>

                {{-- Step 2 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold shadow-lg">
                        2
                    </div>
                    <h3 class="font-bold text-base text-gray-800 mb-2">Datang & Donor</h3>
                    <p class="text-sm text-gray-600">
                        Datang ke lokasi pada hari yang ditentukan dan kami akan proses donor darah dengan aman
                    </p>
                </div>

                {{-- Step 3 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold shadow-lg">
                        3
                    </div>
                    <h3 class="font-bold text-base text-gray-800 mb-2">Pahlawan Banyak!</h3>
                    <p class="text-sm text-gray-600">
                        Selamat! Anda telah menjadi pahlawan dan menyelamatkan nyawa dengan darah Anda
                    </p>
                </div>
            </div>

            {{-- Blue Process Section --}}
            <div class="text-center mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Butuh Donor Cepat?</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Step 1 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold shadow-lg">
                        1
                    </div>
                    <h3 class="font-bold text-base text-gray-800 mb-2">Isi Formulir</h3>
                    <p class="text-sm text-gray-600">
                        Lengkapi formulir permintaan donor dengan data pasien yang membutuhkan
                    </p>
                </div>

                {{-- Step 2 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold shadow-lg">
                        2
                    </div>
                    <h3 class="font-bold text-base text-gray-800 mb-2">Kami Proses</h3>
                    <p class="text-sm text-gray-600">
                        Tim kami akan mencari pendonor yang sesuai dengan golongan darah yang dibutuhkan
                    </p>
                </div>

                {{-- Step 3 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold shadow-lg">
                        3
                    </div>
                    <h3 class="font-bold text-base text-gray-800 mb-2">Terima Bantuan</h3>
                    <p class="text-sm text-gray-600">
                        Kami akan menghubungi Anda dengan informasi pendonor yang tersedia
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Final Section --}}
    @guest
    <section class="py-16 bg-gradient-to-br from-red-600 via-red-700 to-red-800 text-white relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white rounded-full -translate-x-1/2 translate-y-1/2"></div>
        </div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-xl md:text-2xl font-bold mb-3">Siap Menjadi Pahlawan?</h2>
            <p class="text-base text-red-50 mb-6">
                Donor darah Anda dapat menyelamatkan hingga 3 nyawa
            </p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('register') }}" class="px-6 py-2.5 bg-white text-red-600 text-sm font-semibold rounded-lg hover:bg-gray-100 transition-all shadow-lg">
                    Daftar Sebagai Pendonor
                </a>
                <a href="{{ route('login') }}" class="px-6 py-2.5 bg-transparent border-2 border-white text-white text-sm font-semibold rounded-lg hover:bg-white hover:text-red-600 transition-all">
                    Butuh Darah Cepat?
                </a>
            </div>
        </div>
    </section>
    @endguest
@endsection