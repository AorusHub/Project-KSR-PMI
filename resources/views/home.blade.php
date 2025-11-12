{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\home.blade.php --}}
@extends('layouts.guest')

@section('title', 'Beranda - KSR PMI UNHAS')

@section('content')
    {{-- Hero Section --}}
    <section class="bg-gradient-to-r from-red-600 to-red-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                {{-- Left: Text Content --}}
                <div class="space-y-6">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                        Setetes Darah Anda,<br>
                        Nyawa Bagi Sesama
                    </h1>
                    <p class="text-lg text-red-100">
                        Bergabunglah dengan ribuan pendonor sukarela KSR PMI UNHAS
                        dan jadilah pahlawan nyawa hari ini.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-white text-red-600 font-bold rounded-lg hover:bg-gray-100 transition-colors shadow-lg">
                            Daftar Pendonor Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-transparent border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-red-600 transition-colors">
                            Butuh Darah Cepat?
                        </a>
                        <a href="#kegiatan" class="px-6 py-3 bg-transparent border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-red-600 transition-colors">
                            Lihat Jadwal Kegiatan
                        </a>
                    </div>
                </div>

                {{-- Right: Image/Illustration --}}
                <div class="hidden lg:block">
                    <img src="{{ asset('images/hero-donor.png') }}" alt="Donor Darah" class="w-full h-auto" onerror="this.style.display='none'">
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Stat 1 --}}
                <div class="bg-white rounded-lg shadow-lg p-6 text-center border-t-4 border-red-600">
                    <div class="text-red-600 mb-2">
                        <svg class="w-12 h-12 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalPendonor ?? '5,247' }}</h3>
                    <p class="text-gray-600 text-sm mt-1">Total Pendonor Terdaftar</p>
                </div>

                {{-- Stat 2 --}}
                <div class="bg-white rounded-lg shadow-lg p-6 text-center border-t-4 border-red-600">
                    <div class="text-red-600 mb-2">
                        <svg class="w-12 h-12 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalDonasi ?? '12,438' }}</h3>
                    <p class="text-gray-600 text-sm mt-1">Kantong Darah Terkumpul</p>
                </div>

                {{-- Stat 3 --}}
                <div class="bg-white rounded-lg shadow-lg p-6 text-center border-t-4 border-red-600">
                    <div class="text-red-600 mb-2">
                        <svg class="w-12 h-12 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalKegiatan ?? '48' }}</h3>
                    <p class="text-gray-600 text-sm mt-1">Kegiatan Donor Tahun Ini</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Kegiatan Donor Terdekat Section --}}
    <section id="kegiatan" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-3">Kegiatan Donor Terdekat</h2>
                <p class="text-gray-600">Daftar kegiatan donor darah yang akan dilaksanakan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($kegiatanTerdekat ?? [] as $kegiatan)
                {{-- Card Kegiatan dari Database --}}
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="{{ asset('images/donor-' . $loop->iteration . '.jpg') }}" alt="Donor Darah" class="w-full h-48 object-cover" onerror="this.src='https://via.placeholder.com/400x300/dc2626/ffffff?text=Donor+Darah'">
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-gray-800 mb-2">{{ $kegiatan->nama_kegiatan }}</h3>
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d F Y') }}, {{ $kegiatan->waktu_mulai }} - {{ $kegiatan->waktu_selesai }} WITA
                            </p>
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                {{ $kegiatan->lokasi }}
                            </p>
                        </div>
                        <a href="{{ route('login') }}" class="block w-full text-center bg-red-600 text-white font-bold py-2 rounded-lg hover:bg-red-700 transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @empty
                {{-- Card Kegiatan Default 1 --}}
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="{{ asset('images/donor-1.jpg') }}" alt="Donor Darah" class="w-full h-48 object-cover" onerror="this.src='https://via.placeholder.com/400x300/dc2626/ffffff?text=Donor+Darah'">
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-gray-800 mb-2">Donor Darah Kampus UNHAS</h3>
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                15 November 2024, 08:00 - 16:00 WITA
                            </p>
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                Gedung Andi Pangerang UNHAS
                            </p>
                        </div>
                        <a href="{{ route('login') }}" class="block w-full text-center bg-red-600 text-white font-bold py-2 rounded-lg hover:bg-red-700 transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                </div>

                {{-- Card Kegiatan Default 2 --}}
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="{{ asset('images/donor-2.jpg') }}" alt="Donor Darah" class="w-full h-48 object-cover" onerror="this.src='https://via.placeholder.com/400x300/dc2626/ffffff?text=Donor+Darah'">
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-gray-800 mb-2">Donor Darah Untuk Masa Depan</h3>
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                20 November 2024, 09:00 - 15:00 WITA
                            </p>
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                Fakultas Kedokteran UNHAS
                            </p>
                        </div>
                        <a href="{{ route('login') }}" class="block w-full text-center bg-red-600 text-white font-bold py-2 rounded-lg hover:bg-red-700 transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                </div>

                {{-- Card Kegiatan Default 3 --}}
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="{{ asset('images/donor-3.jpg') }}" alt="Donor Darah" class="w-full h-48 object-cover" onerror="this.src='https://via.placeholder.com/400x300/dc2626/ffffff?text=Donor+Darah'">
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-gray-800 mb-2">Donor Darah HUT Kemerdekaan</h3>
                        <div class="space-y-2 text-sm text-gray-600 mb-4">
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                01 Desember 2024, 08:00 - 14:00 WITA
                            </p>
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                Lapangan Rektorat UNHAS
                            </p>
                        </div>
                        <a href="{{ route('login') }}" class="block w-full text-center bg-red-600 text-white font-bold py-2 rounded-lg hover:bg-red-700 transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

            <div class="text-center mt-8">
                <a href="{{ url('/kegiatan') }}" class="inline-block px-8 py-3 border-2 border-red-600 text-red-600 font-bold rounded-lg hover:bg-red-600 hover:text-white transition-colors">
                    Lihat Semua Kegiatan
                </a>
            </div>
        </div>
    </section>

    {{-- Mengapa Donor Darah Section --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-3">Mengapa Donor Darah?</h2>
                <p class="text-gray-600">Manfaat donor darah bagi kesehatan dan kemanusiaan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Benefit 1 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">💪</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Baik untuk Kesehatan</h3>
                    <p class="text-gray-600 text-sm">
                        Donor darah secara teratur dapat membantu menurunkan risiko penyakit jantung dan meningkatkan produksi sel darah merah.
                    </p>
                </div>

                {{-- Benefit 2 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">❤️</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Selamatkan Nyawa</h3>
                    <p class="text-gray-600 text-sm">
                        Satu kantong darah dapat menyelamatkan hingga 3 nyawa. Jadilah pahlawan bagi mereka yang membutuhkan.
                    </p>
                </div>

                {{-- Benefit 3 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-3xl">🩺</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Cek Kesehatan Gratis</h3>
                    <p class="text-gray-600 text-sm">
                        Setiap kali donor darah, Anda akan mendapatkan pemeriksaan kesehatan gratis termasuk cek tekanan darah dan HB.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Cara Donor Darah Section --}}
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-3">Butuh Darah Cepat?</h2>
                <p class="text-gray-600">Ikuti langkah mudah untuk mendapatkan bantuan darah</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Step 1 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-2xl font-bold">1</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Isi Formulir</h3>
                    <p class="text-gray-600 text-sm">
                        Lengkapi formulir permintaan donor darah dengan data yang lengkap dan akurat.
                    </p>
                </div>

                {{-- Step 2 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-2xl font-bold">2</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Verifikasi</h3>
                    <p class="text-gray-600 text-sm">
                        Tim kami akan memverifikasi permintaan Anda dan mencari pendonor yang sesuai.
                    </p>
                </div>

                {{-- Step 3 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-2xl font-bold">3</span>
                    </div>
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Terima Bantuan</h3>
                    <p class="text-gray-600 text-sm">
                        Dapatkan bantuan darah sesuai kebutuhan dari jaringan pendonor kami.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-16 bg-gradient-to-r from-red-600 to-red-700 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Siap Menjadi Pendonor?</h2>
            <p class="text-xl text-red-100 mb-8">
                Donor darah Anda dapat menyelamatkan hingga 3 nyawa
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-red-600 font-bold rounded-lg hover:bg-gray-100 transition-colors shadow-lg">
                    Daftar Sebagai Pendonor
                </a>
                <a href="{{ url('/permintaan-donor') }}" class="px-8 py-3 bg-transparent border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-red-600 transition-colors">
                    Cari Kebutuhan Darah
                </a>
            </div>
        </div>
    </section>
@endsection