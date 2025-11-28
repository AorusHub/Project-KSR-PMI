{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\admin\detail-user-management.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-gray-700 hover:text-gray-900 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="font-medium">Kembali ke Manajemen Pengguna</span>
            </a>
        </div>

        {{-- Header Title --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Riwayat Donasi</h1>
            <p class="text-gray-600 mt-1">Melihat riwayat donasi oleh pengguna</p>
        </div>

        {{-- Main Grid Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- LEFT COLUMN: STATS CARDS --}}
            <div class="lg:col-span-1 space-y-6">
                
                {{-- Total Donasi Card --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Total Donasi</p>
                            <p class="text-5xl font-bold text-red-600">{{ $totalDonasi }}</p>
                            <p class="text-xs text-gray-500 mt-2">Kantong darah didonorkan</p>
                        </div>
                        <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Donasi Terakhir Card --}}
                @php 
                    $lastDonation = $pendonor->donasiDarah->sortByDesc('tanggal_donasi')->first(); 
                @endphp
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Donasi Terakhir</p>
                            @if($lastDonation)
                                <p class="text-2xl font-bold text-gray-900">{{ \Carbon\Carbon::parse($lastDonation->tanggal_donasi)->format('d/m/Y') }}</p>
                                <p class="text-xs text-gray-500 mt-2">{{ Str::limit($lastDonation->lokasi_donor, 30) }}</p>
                            @else
                                <p class="text-2xl font-bold text-gray-900">-</p>
                                <p class="text-xs text-gray-500 mt-2">Belum ada donasi</p>
                            @endif
                        </div>
                        <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Donor Berikutnya Card --}}
                @php
                    $nextDonation = $lastDonation 
                        ? \Carbon\Carbon::parse($lastDonation->tanggal_donasi)->addMonths(3)->format('d/m/Y') 
                        : '-';
                @endphp
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Donor Berikutnya</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $nextDonation }}</p>
                            <p class="text-xs text-gray-500 mt-2">Pengguna dapat donor kembali</p>
                        </div>
                        <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN: PROFILE & HISTORY --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Profile Card --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 rounded-full bg-red-600 text-white flex items-center justify-center text-4xl font-bold mb-4">
                            {{ strtoupper(substr($pendonor->nama ?? 'U', 0, 1)) }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $pendonor->nama ?? 'Nama Pendonor' }}</h3>
                        <p class="text-sm text-gray-600 mt-1">Golongan Darah: <span class="font-semibold text-red-600">{{ $pendonor->golongan_darah ?? '-' }}</span></p>
                    </div>

                    {{-- Profile Info Vertical --}}
                    <div class="mt-8 pt-6 border-t border-gray-200 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Email</span>
                            <span class="text-sm text-gray-900 font-medium">{{ $pendonor->email ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center border-t border-gray-100 pt-4">
                            <span class="text-sm text-gray-600">No. HP</span>
                            <span class="text-sm text-gray-900 font-medium">{{ $pendonor->no_hp ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center border-t border-gray-100 pt-4">
                            <span class="text-sm text-gray-600">Member sejak</span>
                            <span class="text-sm text-gray-900 font-medium">{{ $pendonor->created_at ? \Carbon\Carbon::parse($pendonor->created_at)->format('Y') : '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Donation History Card --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-gray-900">Riwayat Donasi</h2>
                        <button class="text-sm text-red-600 hover:text-red-700 font-semibold">Lihat Detail</button>
                    </div>

                    {{-- Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Kegiatan</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Lokasi</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($pendonor->donasiDarah->sortByDesc('tanggal_donasi') as $donasi)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($donasi->tanggal_donasi)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $donasi->kegiatan->nama_kegiatan ?? 'Donor Mandiri' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $donasi->lokasi_donor ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($donasi->status_donasi == 'Selesai')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                Berhasil
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                Gagal
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Belum ada riwayat donasi</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection