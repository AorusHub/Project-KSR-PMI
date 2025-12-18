{{-- filepath: e:\Project-KSR-PMI\resources\views\dashboard\pendonor\pendonor-profile.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-4 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Success Message --}}
        @if(session('success'))
        <div class="mb-4 sm:mb-6 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 dark:border-green-400 p-4 rounded">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-green-700 dark:text-green-300 font-medium text-sm sm:text-base">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            
            {{-- Left Sidebar - Profile Summary --}}
            <div class="lg:col-span-1 order-2 lg:order-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-6">
                    
                    {{-- Header Card --}}
                    <div class="text-left mb-4 sm:mb-6">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Profil Pengguna</h2>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Menampilkan informasi profil</p>
                    </div>

                    {{-- Total Donasi Card --}}
                    <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-4 mb-3 sm:mb-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-1">Total Donasi</p>
                                <p class="text-3xl sm:text-4xl font-bold text-red-600 dark:text-red-500">{{ $totalDonasi ?? 5 }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Kantong darah didonorkan</p>
                            </div>
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-50 dark:bg-red-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600 dark:text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Donasi Terakhir Card --}}
                    <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-4 mb-3 sm:mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">Donasi Terakhir</p>
                            <div class="w-7 h-7 sm:w-8 sm:h-8 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $donorTerakhir ?? '17/9/2025' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PMI Kota Makassar</p>
                    </div>

                    {{-- Donor Berikutnya Card --}}
                    <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">Donor Berikutnya</p>
                            <div class="w-7 h-7 sm:w-8 sm:h-8 bg-green-50 dark:bg-green-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $donorBerikutnya ?? '16/12/2025' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pengguna dapat donor kembali</p>
                    </div>

                </div>
            </div>

            {{-- Right Content - Profile View --}}
            <div class="lg:col-span-2 order-1 lg:order-2">
                <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-sm p-4 sm:p-6 lg:p-8">
                    
                    {{-- Avatar & Name --}}
                    <div class="flex flex-col items-center mb-6 sm:mb-8 pb-4 sm:pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-red-500 to-red-600 dark:from-red-600 dark:to-red-700 rounded-full flex items-center justify-center text-white text-3xl sm:text-4xl font-bold shadow-lg mb-3 sm:mb-4">
                            {{ strtoupper(substr($pendonor->nama ?? 'Nama Pendonor', 0, 1)) }}
                        </div>
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white text-center">{{ $pendonor->nama ?? 'Nama Pendonor' }}</h2>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">Golongan Darah: <span class="font-semibold text-red-600 dark:text-red-500">{{ $pendonor->golongan_darah ?? 'A+' }}</span></p>
                    </div>

                    {{-- Profile Information (Read Only) --}}
                    <div class="space-y-0">

                        {{-- Tanggal Lahir --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4 py-3 sm:py-4 border-b border-gray-100 dark:border-gray-700 group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition px-2 sm:px-0 -mx-2 sm:mx-0 rounded">
                            <span class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 font-medium sm:font-normal">Tanggal Lahir</span>
                            <div class="flex items-center justify-start sm:justify-end space-x-2">
                                <span class="text-xs sm:text-sm text-gray-900 dark:text-white font-medium">
                                    {{ $pendonor->tanggal_lahir ? $pendonor->tanggal_lahir->format('d F Y') : '09 Februari 2006' }}
                                </span>
                                <a href="#" class="opacity-0 sm:group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 hover:text-red-600 dark:hover:text-red-500 transition" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4 py-3 sm:py-4 border-b border-gray-100 dark:border-gray-700 group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition px-2 sm:px-0 -mx-2 sm:mx-0 rounded">
                            <span class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 font-medium sm:font-normal">Jenis Kelamin</span>
                            <div class="flex items-center justify-start sm:justify-end space-x-2">
                                <span class="text-xs sm:text-sm text-gray-900 dark:text-white font-medium">
                                    {{ $pendonor->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                                <a href="#" class="opacity-0 sm:group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 hover:text-red-600 dark:hover:text-red-500 transition" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- NIK --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4 py-3 sm:py-4 border-b border-gray-100 dark:border-gray-700 group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition px-2 sm:px-0 -mx-2 sm:mx-0 rounded">
                            <span class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 font-medium sm:font-normal">NIK</span>
                            <div class="flex items-center justify-start sm:justify-end space-x-2">
                                <span class="text-xs sm:text-sm text-gray-900 dark:text-white font-medium">{{ $pendonor->NIK ?? '123456789' }}</span>
                                <a href="#" class="opacity-0 sm:group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 hover:text-red-600 dark:hover:text-red-500 transition" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4 py-3 sm:py-4 border-b border-gray-100 dark:border-gray-700 group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition px-2 sm:px-0 -mx-2 sm:mx-0 rounded">
                            <span class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 font-medium sm:font-normal">Email</span>
                            <div class="flex items-center justify-start sm:justify-end space-x-2">
                                <span class="text-xs sm:text-sm text-gray-900 dark:text-white font-medium break-all">{{ Auth::user()->email ?? 'pendonor@demo.com' }}</span>
                                <a href="#" class="opacity-0 sm:group-hover:opacity-100 transition flex-shrink-0">
                                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 hover:text-red-600 dark:hover:text-red-500 transition" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- No. HP --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4 py-3 sm:py-4 border-b border-gray-100 dark:border-gray-700 group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition px-2 sm:px-0 -mx-2 sm:mx-0 rounded">
                            <span class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 font-medium sm:font-normal">No. HP</span>
                            <div class="flex items-center justify-start sm:justify-end space-x-2">
                                <span class="text-xs sm:text-sm text-gray-900 dark:text-white font-medium">{{ $pendonor->no_hp ?? '081234567890' }}</span>
                                <a href="#" class="opacity-0 sm:group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 hover:text-red-600 dark:hover:text-red-500 transition" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4 py-3 sm:py-4 border-b border-gray-100 dark:border-gray-700 group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition px-2 sm:px-0 -mx-2 sm:mx-0 rounded">
                            <span class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 font-medium sm:font-normal">Password</span>
                            <div class="flex items-center justify-start sm:justify-end space-x-2">
                                <span class="text-xs sm:text-sm text-gray-900 dark:text-white font-medium">••••••••</span>
                                <a href="#" class="opacity-0 sm:group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 hover:text-red-600 dark:hover:text-red-500 transition" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection