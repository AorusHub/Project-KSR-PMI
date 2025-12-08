{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\pendonor.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Pendonor - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Welcome Section --}}
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                Selamat Datang, {{ $pendonor->nama ?? Auth::user()->nama }}!
            </h1>
            <p class="text-gray-600">
                Terima kasih atas dedikasi Anda sebagai pendonor darah
            </p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- Total Donasi --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-4">
                    <span class="text-sm font-medium text-gray-600">Total Donasi</span>
                    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p class="text-5xl font-bold text-red-600 mb-2">{{ $totalDonasi ?? 5 }}</p>
                <p class="text-sm text-gray-500">Kantong darah didonorkan</p>
            </div>

            {{-- Donasi Terakhir --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-4">
                    <span class="text-sm font-medium text-gray-600">Donasi Terakhir</span>
                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-2">
                    {{ $donasiTerakhir ? $donasiTerakhir->tanggal_donasi->format('d/m/Y') : '17/9/2025' }}
                </p>
                <p class="text-sm text-gray-500">
                    {{ $donasiTerakhir ? $donasiTerakhir->lokasi_donor : 'PMI Kota Makassar' }}
                </p>
            </div>

            {{-- Donor Berikutnya --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-4">
                    <span class="text-sm font-medium text-gray-600">Donor Berikutnya</span>
                    <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-2">
                    {{ $donorBerikutnya ? $donorBerikutnya->format('d/m/Y') : '16/12/2025' }}
                </p>
                <p class="text-sm text-gray-500">Anda dapat donor kembali</p>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Left Column: Riwayat Donor --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Riwayat Donasi Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-900">Riwayat Donasi</h2>
                        <a href="{{ route('pendonor.riwayat-donor') }}" class="text-sm text-red-600 hover:text-red-700 font-bold">
                            Lihat Detail
                        </a>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Tanggal</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Kegiatan</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Lokasi</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($riwayatDonasi ?? [] as $donasi)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-4 text-sm text-gray-900">{{ $donasi->tanggal_donasi->format('d/m/Y') }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">{{ $donasi->kegiatan->nama_kegiatan ?? 'Donor Mandiri' }}</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">{{ $donasi->lokasi_donor }}</td>
                                        <td class="px-4 py-4">
                                            @if($donasi->status_donasi == 'Berhasil')
                                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">Berhasil</span>
                                            @else
                                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700">Gagal</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="px-4 py-4 text-sm text-gray-900">17/9/2025</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">Donor Darah Hari PMI</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">PMI Kota Makassar</td>
                                        <td class="px-4 py-4">
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">Berhasil</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-4 text-sm text-gray-900">15/6/2025</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">Donor Darah Kampus UNHAS</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">Gedung Rektorat UNHAS</td>
                                        <td class="px-4 py-4">
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">Berhasil</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-4 text-sm text-gray-900">10/3/2025</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">Donor Darah Masjid Raya</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">Masjid Raya Makassar</td>
                                        <td class="px-4 py-4">
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">Berhasil</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-4 text-sm text-gray-900">20/12/2024</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">Donor Darah Mall Panakkukang</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">Mall Panakkukang</td>
                                        <td class="px-4 py-4">
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700">Gagal</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-4 text-sm text-gray-900">15/9/2024</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">Donor Darah Fakultas Kedokteran</td>
                                        <td class="px-4 py-4 text-sm text-gray-900">FK UNHAS</td>
                                        <td class="px-4 py-4">
                                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">Berhasil</span>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Permintaan Darah & Aksi Cepat Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Permintaan Darah --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Permintaan Darah</h3>
                        <div class="space-y-3">
                            <a href="{{ route('pendonor.permintaan-darah.create') }}" class="flex items-center p-4 border border-gray-200 rounded-xl hover:border-red-200 hover:bg-red-50 transition-all group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-red-600">Ajukan Permintaan Darah</span>
                            </a>
                            <a href="{{ route('pendonor.permintaan-darah') }}" class="flex items-center p-4 border border-gray-200 rounded-xl hover:border-red-200 hover:bg-red-50 transition-all group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-red-600">Lihat Permintaan Darah</span>
                            </a>
                        </div>
                    </div>

                    {{-- Aksi Cepat --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Aksi Cepat</h3>
                        <div class="space-y-3">
                            <a href="{{ route('kegiatan.index') }}" class="flex items-center p-4 border border-gray-200 rounded-xl hover:border-red-200 hover:bg-red-50 transition-all group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-red-600">Cari Kegiatan Donor</span>
                            </a>
                            <a href="{{ route('pendonor.cek-kelayakan-donor') }}" class="flex items-center p-4 border border-gray-200 rounded-xl hover:border-red-200 hover:bg-red-50 transition-all group">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-red-600">Cek Kelayakan Donor</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Right Column: Profile --}}
            <div class="space-y-6">
                
                {{-- Profile Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10">
                    <div class="flex flex-col items-center text-center mb-8">
                        <div class="w-28 h-28 rounded-full bg-red-600 text-white flex items-center justify-center text-5xl font-bold mb-4">
                            {{ strtoupper(substr($pendonor->nama ?? 'U', 0, 1)) }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $pendonor->nama ?? 'Nama Pendonor' }}</h3>
                        <p class="text-sm text-gray-600">Golongan Darah: <span class="font-semibold">{{ $pendonor->golongan_darah ?? 'A+' }}</span></p>
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-600">Email</span>
                            <span class="text-sm text-gray-900 font-medium">{{ $pendonor->email ?? 'donor@demo.com' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm text-gray-600">No. HP</span>
                            <span class="text-sm text-gray-900 font-medium">{{ $pendonor->no_hp ?? '081234567890' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-sm text-gray-600">Member sejak</span>
                            <span class="text-sm text-gray-900 font-medium">{{ $pendonor->created_at ? $pendonor->created_at->format('Y') : '2024' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Pendonor Aktif Badge --}}
                <div class="bg-gradient-to-br from-red-600 to-red-700 rounded-2xl shadow-lg p-7 text-white text-center">
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Pendonor Aktif</h3>
                    <p class="text-sm text-red-100 leading-relaxed">
                        Terima kasih telah mendonorkan darah 5x
                        <br>15 nyawa berpotensi diselamatkan
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection