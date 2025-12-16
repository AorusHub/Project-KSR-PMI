{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\pendonor.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Pendonor - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 sm:py-8 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Welcome Section --}}
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Selamat Datang, {{ $pendonor->nama ?? Auth::user()->nama }}!
            </h1>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
                Terima kasih atas dedikasi Anda sebagai pendonor darah
            </p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            {{-- Total Donasi --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 sm:p-6 transition-all hover:shadow-md">
                <div class="flex items-start justify-between mb-3 sm:mb-4">
                    <span class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Total Donasi</span>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-50 dark:bg-red-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl sm:text-5xl font-bold text-red-600 dark:text-red-400 mb-1 sm:mb-2">{{ $totalDonasi ?? 5 }}</p>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Kantong darah didonorkan</p>
            </div>

            {{-- Donasi Terakhir --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 sm:p-6 transition-all hover:shadow-md">
                <div class="flex items-start justify-between mb-3 sm:mb-4">
                    <span class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Donasi Terakhir</span>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-1 sm:mb-2">
                    {{ $donasiTerakhir ? $donasiTerakhir->tanggal_donasi->format('d/m/Y') : '17/9/2025' }}
                </p>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 truncate">
                    {{ $donasiTerakhir ? $donasiTerakhir->lokasi_donor : 'PMI Kota Makassar' }}
                </p>
            </div>

            {{-- Donor Berikutnya --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 sm:p-6 transition-all hover:shadow-md sm:col-span-2 lg:col-span-1">
                <div class="flex items-start justify-between mb-3 sm:mb-4">
                    <span class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Donor Berikutnya</span>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-50 dark:bg-green-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-1 sm:mb-2">
                    {{ $donorBerikutnya ? $donorBerikutnya->format('d/m/Y') : '16/12/2025' }}
                </p>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Anda dapat donor kembali</p>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Left Column: Riwayat Donor --}}
            <div class="lg:col-span-2 space-y-4 sm:space-y-6">
                
                {{-- Riwayat Donasi Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors">
                    <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                        <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">Riwayat Donasi</h2>
                        <a href="{{ route('pendonor.riwayat-donor') }}" class="text-xs sm:text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-bold transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                    <div class="p-4 sm:p-6">
                        {{-- Desktop Table View --}}
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase">Tanggal</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase">Kegiatan</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase">Lokasi</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @forelse($riwayatDonasi ?? [] as $donasi)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $donasi->tanggal_donasi->format('d/m/Y') }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $donasi->kegiatan->nama_kegiatan ?? 'Donor Mandiri' }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $donasi->lokasi_donor }}</td>
                                        <td class="px-4 py-4">
                                            @if($donasi->status_donasi == 'Berhasil')
                                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">Berhasil</span>
                                            @else
                                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400">Gagal</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">17/9/2025</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">Donor Darah Hari PMI</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">PMI Kota Makassar</td>
                                        <td class="px-4 py-4">
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">Berhasil</span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">15/6/2025</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">Donor Darah Kampus UNHAS</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">Gedung Rektorat UNHAS</td>
                                        <td class="px-4 py-4">
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">Berhasil</span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">10/3/2025</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">Donor Darah Masjid Raya</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">Masjid Raya Makassar</td>
                                        <td class="px-4 py-4">
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">Berhasil</span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">20/12/2024</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">Donor Darah Mall Panakkukang</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">Mall Panakkukang</td>
                                        <td class="px-4 py-4">
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400">Gagal</span>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">15/9/2024</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">Donor Darah Fakultas Kedokteran</td>
                                        <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">FK UNHAS</td>
                                        <td class="px-4 py-4">
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">Berhasil</span>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile/Tablet Card View --}}
                        <div class="lg:hidden space-y-3">
                            @forelse($riwayatDonasi ?? [] as $donasi)
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $donasi->kegiatan->nama_kegiatan ?? 'Donor Mandiri' }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $donasi->tanggal_donasi->format('d/m/Y') }}</p>
                                    </div>
                                    @if($donasi->status_donasi == 'Berhasil')
                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 whitespace-nowrap">Berhasil</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 whitespace-nowrap">Gagal</span>
                                    @endif
                                </div>
                                <div class="flex items-center text-xs text-gray-600 dark:text-gray-400">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $donasi->lokasi_donor }}
                                </div>
                            </div>
                            @empty
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">Donor Darah Hari PMI</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">17/9/2025</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">Berhasil</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-600 dark:text-gray-400">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                    PMI Kota Makassar
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">Donor Darah Kampus UNHAS</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">15/6/2025</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">Berhasil</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-600 dark:text-gray-400">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                    Gedung Rektorat UNHAS
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">Donor Darah Masjid Raya</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">10/3/2025</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">Berhasil</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-600 dark:text-gray-400">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                    Masjid Raya Makassar
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">Donor Darah Mall Panakkukang</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">20/12/2024</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400">Gagal</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-600 dark:text-gray-400">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                    Mall Panakkukang
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">Donor Darah Fakultas Kedokteran</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">15/9/2024</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">Berhasil</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-600 dark:text-gray-400">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                    FK UNHAS
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Permintaan Darah & Aksi Cepat Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    
                    {{-- Permintaan Darah --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 sm:p-6 transition-colors">
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-4 sm:mb-6">Permintaan Darah</h3>
                        <div class="space-y-2 sm:space-y-3">
                            <a href="{{ route('pendonor.permintaan-darah.create') }}" class="flex items-center p-3 sm:p-4 border border-gray-200 dark:border-gray-700 rounded-lg sm:rounded-xl hover:border-red-200 dark:hover:border-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all group">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 dark:text-gray-500 group-hover:text-red-600 dark:group-hover:text-red-400 mr-2 sm:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">Ajukan Permintaan Darah</span>
                            </a>
                            <a href="{{ route('pendonor.permintaan-darah') }}" class="flex items-center p-3 sm:p-4 border border-gray-200 dark:border-gray-700 rounded-lg sm:rounded-xl hover:border-red-200 dark:hover:border-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all group">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 dark:text-gray-500 group-hover:text-red-600 dark:group-hover:text-red-400 mr-2 sm:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">Lihat Permintaan Darah</span>
                            </a>
                        </div>
                    </div>

                    {{-- Aksi Cepat --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 sm:p-6 transition-colors">
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-4 sm:mb-6">Aksi Cepat</h3>
                        <div class="space-y-2 sm:space-y-3">
                            <a href="{{ route('kegiatan.index') }}" class="flex items-center p-3 sm:p-4 border border-gray-200 dark:border-gray-700 rounded-lg sm:rounded-xl hover:border-red-200 dark:hover:border-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all group">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 dark:text-gray-500 group-hover:text-red-600 dark:group-hover:text-red-400 mr-2 sm:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">Cari Kegiatan Donor</span>
                            </a>
                            <a href="{{ route('pendonor.cek-kelayakan-donor') }}" class="flex items-center p-3 sm:p-4 border border-gray-200 dark:border-gray-700 rounded-lg sm:rounded-xl hover:border-red-200 dark:hover:border-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all group">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 dark:text-gray-500 group-hover:text-red-600 dark:group-hover:text-red-400 mr-2 sm:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">Cek Kelayakan Donor</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Right Column: Profile --}}
            <div class="space-y-4 sm:space-y-6">
                
                {{-- Profile Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 sm:p-8 lg:p-10 transition-colors">
                    <div class="flex flex-col items-center text-center mb-6 sm:mb-8">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 lg:w-28 lg:h-28 rounded-full bg-red-600 dark:bg-red-700 text-white flex items-center justify-center text-4xl sm:text-5xl font-bold mb-3 sm:mb-4">
                            {{ strtoupper(substr($pendonor->nama ?? 'U', 0, 1)) }}
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $pendonor->nama ?? 'Nama Pendonor' }}</h3>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Golongan Darah: <span class="font-semibold text-gray-900 dark:text-white">{{ $pendonor->golongan_darah ?? 'A+' }}</span></p>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between items-center py-2 sm:py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Email</span>
                            <span class="text-xs sm:text-sm text-gray-900 dark:text-white font-medium truncate ml-2 max-w-[150px] sm:max-w-none">{{ $pendonor->email ?? 'donor@demo.com' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 sm:py-3 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">No. HP</span>
                            <span class="text-xs sm:text-sm text-gray-900 dark:text-white font-medium">{{ $pendonor->no_hp ?? '081234567890' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 sm:py-3">
                            <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Member sejak</span>
                            <span class="text-xs sm:text-sm text-gray-900 dark:text-white font-medium">{{ $pendonor->created_at ? $pendonor->created_at->format('Y') : '2024' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Pendonor Aktif Badge --}}
                <div class="bg-gradient-to-br from-red-600 via-red-700 to-red-800 dark:from-red-700 dark:via-red-800 dark:to-red-900 rounded-xl sm:rounded-2xl shadow-lg dark:shadow-xl p-6 sm:p-7 text-white text-center transition-all">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-white bg-opacity-20 dark:bg-opacity-30 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3">Pendonor Aktif</h3>
                    <p class="text-xs sm:text-sm text-red-100 dark:text-red-200 leading-relaxed px-2">
                        Terima kasih telah mendonorkan darah 5x
                        <br class="hidden sm:block">15 nyawa berpotensi diselamatkan
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection