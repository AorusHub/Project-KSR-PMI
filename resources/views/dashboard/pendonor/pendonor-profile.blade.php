{{-- filepath: e:\Project-KSR-PMI\resources\views\dashboard\pendonor\pendonor-profile.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Success Message --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Left Sidebar - Profile Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    
                    {{-- Header Card --}}
                    <div class="text-left mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Profil Pengguna</h2>
                        <p class="text-sm text-gray-500 mt-1">Menampilkan informasi profil</p>
                    </div>

                    {{-- Total Donasi Card --}}
                    <div class="bg-white border border-gray-200 rounded-xl p-4 mb-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Total Donasi</p>
                                <p class="text-4xl font-bold text-red-600">{{ $totalDonasi ?? 5 }}</p>
                                <p class="text-xs text-gray-500 mt-1">Kantong darah didonorkan</p>
                            </div>
                            <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Donasi Terakhir Card --}}
                    <div class="bg-white border border-gray-200 rounded-xl p-4 mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-900">Donasi Terakhir</p>
                            <div class="w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ $donorTerakhir ?? '17/9/2025' }}</p>
                        <p class="text-xs text-gray-500 mt-1">PMI Kota Makassar</p>
                    </div>

                    {{-- Donor Berikutnya Card --}}
                    <div class="bg-white border border-gray-200 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-900">Donor Berikutnya</p>
                            <div class="w-8 h-8 bg-green-50 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ $donorBerikutnya ?? '16/12/2025' }}</p>
                        <p class="text-xs text-gray-500 mt-1">Pengguna dapat donor kembali</p>
                    </div>

                </div>
            </div>

            {{-- Right Content - Profile View --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm p-8">
                    
                    {{-- Avatar & Name --}}
                    <div class="flex flex-col items-center mb-8 pb-6 border-b border-gray-200">
                        <div class="w-24 h-24 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center text-white text-4xl font-bold shadow-lg mb-4">
                            {{ strtoupper(substr($pendonor->nama ?? 'Nama Pendonor', 0, 1)) }}
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 text-center">{{ $pendonor->nama ?? 'Nama Pendonor' }}</h2>
                        <p class="text-sm text-gray-600 mt-1">Golongan Darah: {{ $pendonor->golongan_darah ?? 'A+' }}</p>
                    </div>

                    {{-- Profile Information (Read Only) --}}
                    <div class="space-y-0">

                        {{-- Tanggal Lahir --}}
                        <div class="grid grid-cols-2 gap-4 py-4 border-b border-gray-100 group hover:bg-gray-50 transition">
                            <span class="text-sm text-gray-700">Tanggal Lahir</span>
                            <div class="flex items-center justify-end space-x-2">
                                <span class="text-sm text-gray-900 font-medium">
                                    {{ $pendonor->tanggal_lahir ? $pendonor->tanggal_lahir->format('d F Y') : '09 Februari 2006' }}
                                </span>
                                <a href="#" class="opacity-0 group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-red-600 transition" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="grid grid-cols-2 gap-4 py-4 border-b border-gray-100 group hover:bg-gray-50 transition">
                            <span class="text-sm text-gray-700">Jenis Kelamin</span>
                            <div class="flex items-center justify-end space-x-2">
                                <span class="text-sm text-gray-900 font-medium">
                                    {{ $pendonor->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                                <a href="#" class="opacity-0 group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-red-600 transition" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- NIK --}}
                        <div class="grid grid-cols-2 gap-4 py-4 border-b border-gray-100 group hover:bg-gray-50 transition">
                            <span class="text-sm text-gray-700">NIK</span>
                            <div class="flex items-center justify-end space-x-2">
                                <span class="text-sm text-gray-900 font-medium">{{ $pendonor->NIK ?? '123456789' }}</span>
                                <a href="#" class="opacity-0 group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-red-600 transition" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="grid grid-cols-2 gap-4 py-4 border-b border-gray-100 group hover:bg-gray-50 transition">
                            <span class="text-sm text-gray-700">Email</span>
                            <div class="flex items-center justify-end space-x-2">
                                <span class="text-sm text-gray-900 font-medium">{{ Auth::user()->email ?? 'pendonor@demo.com' }}</span>
                                <a href="#" class="opacity-0 group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-red-600 transition" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- No. HP --}}
                        <div class="grid grid-cols-2 gap-4 py-4 border-b border-gray-100 group hover:bg-gray-50 transition">
                            <span class="text-sm text-gray-700">No. HP</span>
                            <div class="flex items-center justify-end space-x-2">
                                <span class="text-sm text-gray-900 font-medium">{{ $pendonor->no_hp ?? '081234567890' }}</span>
                                <a href="#" class="opacity-0 group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-red-600 transition" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="grid grid-cols-2 gap-4 py-4 border-b border-gray-100 group hover:bg-gray-50 transition">
                            <span class="text-sm text-gray-700">Password</span>
                            <div class="flex items-center justify-end space-x-2">
                                <span class="text-sm text-gray-900 font-medium">••••••••</span>
                                <a href="#" class="opacity-0 group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4 text-gray-400 hover:text-red-600 transition" fill="currentColor" viewBox="0 0 20 20">
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