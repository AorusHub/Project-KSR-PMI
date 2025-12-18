{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\pendonor\riwayat-donor.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Donasi - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 sm:py-8 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Back Button --}}
        <div class="mb-4 sm:mb-6">
            @if(auth()->user()->role === 'admin')
                {{-- Admin kembali ke detail user management --}}
                <a href="{{ route('admin.users.riwayat', $pendonor->pendonor_id) }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="text-sm sm:text-base font-medium">Kembali ke Detail Pengguna</span>
                </a>
            @else
                {{-- Pendonor kembali ke dashboard --}}
                <a href="{{ route('pendonor.dashboard') }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="text-sm sm:text-base font-medium">Kembali ke Dashboard</span>
                </a>
            @endif
        </div>

        {{-- Header --}}
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2 transition-colors">Riwayat Donasi</h1>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 transition-colors">Rekam jejak kontribusi Anda dalam menyelamatkan nyawa</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            {{-- Total Berhasil --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <span class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 transition-colors">Total Donasi Berhasil</span>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-50 dark:bg-red-900/20 rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-1 transition-colors">{{ $totalBerhasil }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 transition-colors">Kantong darah didonasikan</p>
            </div>

            {{-- Nyawa Terselamatkan --}}
            <div class="bg-gradient-to-br from-green-500 to-green-600 dark:from-green-600 dark:to-green-700 rounded-xl shadow-sm p-4 sm:p-6 text-white hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <span class="text-xs sm:text-sm font-medium">Nyawa Terselamatkan</span>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl sm:text-4xl font-bold mb-1">~{{ $nyawaTerselamatkan }}</p>
                <p class="text-xs text-green-100">Estimasi dampak donasi Anda</p>
            </div>

            {{-- Tingkat Keberhasilan --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 hover:shadow-md transition-all sm:col-span-2 lg:col-span-1">
                <div class="flex items-center justify-between mb-3 sm:mb-4">
                    <span class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 transition-colors">Tingkat Keberhasilan</span>
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-50 dark:bg-green-900/20 rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-1 transition-colors">{{ $persentaseKeberhasilan }}%</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 transition-colors">Dari {{ $riwayatDonasi->count() }} percobaan</p>
            </div>
        </div>

        {{-- Desktop Table View (hidden on mobile) --}}
        <div class="hidden lg:block bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden transition-colors">
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0 transition-colors">
                <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white transition-colors">Riwayat Lengkap</h2>
                
                @if($riwayatDonasi->count() > 0)
                    {{-- Tombol aktif jika ada riwayat --}}
                    @if(auth()->user()->role === 'admin')
                        {{-- Route untuk admin dengan ID pendonor --}}
                        <a href="{{ route('admin.users.export-pdf', $pendonor->pendonor_id) }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                    @else
                        <a href="{{ route('pendonor.riwayat-donor.export-pdf') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                    @endif
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"/>
                            </svg>
                            Export PDF
                        </a>
                @else
                    {{-- Tombol disabled jika belum ada riwayat --}}
                    <button disabled class="inline-flex items-center justify-center px-3 sm:px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-xs sm:text-sm font-medium text-gray-400 dark:text-gray-500 cursor-not-allowed transition-colors">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"/>
                        </svg>
                        Export PDF
                    </button>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 transition-colors">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider transition-colors">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider transition-colors">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider transition-colors">Jenis Donor</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider transition-colors">Lokasi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider transition-colors">Golongan Darah</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider transition-colors">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 transition-colors">
                        @forelse($riwayatDonasi as $index => $donasi)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white transition-colors">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 transition-colors">
                                {{ $donasi->tanggal_donasi->format('d F Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 transition-colors">
                                {{ $donasi->jenis_donor ?? 'Donor Darah Sukarela' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 transition-colors">
                                {{ $donasi->lokasi_donor }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 transition-colors">
                                    {{ $donasi->golongan_darah ?? $pendonor->golongan_darah }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($donasi->status_donasi == 'Berhasil')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 transition-colors">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Berhasil
                                    </span>
                                @elseif($donasi->status_donasi == 'Terdaftar')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 transition-colors">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        Terdaftar
                                    </span>
                                @elseif($donasi->status_donasi == 'Gagal')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 transition-colors">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        Gagal
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 transition-colors">
                                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        Dibatalkan
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-lg font-medium">Belum ada riwayat donasi</p>
                                    <p class="text-sm mt-1">Mulai donor darah untuk membantu menyelamatkan nyawa</p>
                                    <a href="{{ route('pendonor.dashboard') }}" class="mt-4 px-6 py-2 bg-red-600 dark:bg-red-700 text-white rounded-lg hover:bg-red-700 dark:hover:bg-red-600 transition-colors">
                                        Lihat Kegiatan Donor
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile Card View (visible on mobile only) --}}
        <div class="lg:hidden space-y-4">
            {{-- Header for mobile --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 transition-colors">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-base font-bold text-gray-900 dark:text-white transition-colors">Riwayat Lengkap</h2>
                    
                    @if($riwayatDonasi->count() > 0)
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.users.export-pdf', $pendonor->pendonor_id) }}" class="inline-flex items-center px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-xs font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        @else
                            <a href="{{ route('pendonor.riwayat-donor.export-pdf') }}" class="inline-flex items-center px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-xs font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        @endif
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"/>
                                </svg>
                                PDF
                            </a>
                    @else
                        <button disabled class="inline-flex items-center px-3 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-xs font-medium text-gray-400 dark:text-gray-500 cursor-not-allowed">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"/>
                            </svg>
                            PDF
                        </button>
                    @endif
                </div>
            </div>

            {{-- Cards for each donation --}}
            @forelse($riwayatDonasi as $index => $donasi)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 hover:shadow-md transition-all">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-xs font-bold transition-colors">
                                {{ $index + 1 }}
                            </span>
                            @if($donasi->status_donasi == 'Berhasil')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Berhasil
                                </span>
                            @elseif($donasi->status_donasi == 'Terdaftar')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    Terdaftar
                                </span>
                            @elseif($donasi->status_donasi == 'Gagal')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    Gagal
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    Dibatalkan
                                </span>
                            @endif
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1 transition-colors">
                            {{ $donasi->jenis_donor ?? 'Donor Darah Sukarela' }}
                        </h3>
                        <p class="text-xs text-gray-600 dark:text-gray-400 transition-colors">
                            {{ $donasi->tanggal_donasi->format('d F Y') }}
                        </p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 transition-colors">
                        {{ $donasi->golongan_darah ?? $pendonor->golongan_darah }}
                    </span>
                </div>
                
                <div class="pt-3 border-t border-gray-200 dark:border-gray-700 transition-colors">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300 transition-colors">{{ $donasi->lokasi_donor }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 text-center transition-colors">
                <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-base font-medium mb-1">Belum ada riwayat donasi</p>
                    <p class="text-sm mb-4">Mulai donor darah untuk membantu menyelamatkan nyawa</p>
                    <a href="{{ route('pendonor.dashboard') }}" class="px-6 py-2 bg-red-600 dark:bg-red-700 text-white text-sm rounded-lg hover:bg-red-700 dark:hover:bg-red-600 transition-colors">
                        Lihat Kegiatan Donor
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Motivational Banner --}}
        @if(auth()->check() && auth()->user()->pendonor)
            @if($riwayatDonasi->count() > 0)
                <div class="mt-6 sm:mt-8 bg-gradient-to-r from-red-600 to-red-700 dark:from-red-700 dark:to-red-800 rounded-xl shadow-lg p-6 sm:p-8 text-white text-center transition-all">
                    <h3 class="text-xl sm:text-2xl font-bold mb-2">Terima Kasih atas Dedikasi Anda!</h3>
                    <p class="text-sm sm:text-base text-red-100 mb-4 sm:mb-6">
                        Setiap tetes darah yang Anda donasikan adalah hadiah kehidupan bagi mereka yang membutuhkan. 
                        <span class="hidden sm:inline"><br></span>
                        <span class="sm:hidden"> </span>Anda telah menunjukkan kepedulian luar biasa kepada sesama.
                    </p>
                    <div class="flex flex-col sm:flex-row flex-wrap justify-center gap-3 sm:gap-4">
                        <a href="{{ route('pendonor.dashboard') }}" class="px-6 py-3 bg-white text-red-600 rounded-lg text-sm sm:text-base font-semibold hover:bg-gray-100 transition-colors">
                            Donor Lagi
                        </a>
                        <a href="{{ route('pendonor.cek-kelayakan-donor') }}" class="px-6 py-3 bg-transparent border-2 border-white text-white rounded-lg text-sm sm:text-base font-semibold hover:bg-white hover:text-red-600 transition-colors">
                            Cek Kelayakan
                        </a>
                    </div>
                </div>
            @endif
        @endif

    </div>
</div>
@endsection