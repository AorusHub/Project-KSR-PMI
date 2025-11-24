{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\pendonor.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Pendonor - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Welcome Section --}}
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">
                        Selamat Datang, {{ $pendonor->nama ?? Auth::user()->nama }}!
                    </h1>
                    <p class="text-gray-600 text-sm">
                        Terima kasih atas dedikasi Anda sebagai pendonor darah
                    </p>
                </div>
                <div class="hidden md:block">
                    <img src="{{ asset('images/donor-illustration.png') }}" alt="Donor" class="h-16" onerror="this.style.display='none'">
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            {{-- Total Donasi --}}
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600">Total Donasi</span>
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $totalDonasi ?? 5 }}</p>
                <p class="text-xs text-gray-500 mt-1">Kantong darah didonasikan</p>
            </div>

            {{-- Donasi Terakhir --}}
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600">Donasi Terakhir</span>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">
                    {{ $donasiTerakhir ? $donasiTerakhir->tgl_donasi->format('d/m/Y') : '17/9/2025' }}
                </p>
                <p class="text-xs text-gray-500 mt-1">
                    {{ $donasiTerakhir ? $donasiTerakhir->lokasi_donor : 'PMI Kota Makassar' }}
                </p>
            </div>

            {{-- Donor Berikutnya --}}
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-600">Donor Berikutnya</span>
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">
                    {{ $donorBerikutnya ? $donorBerikutnya->format('d/m/Y') : '16/12/2025' }}
                </p>
                <p class="text-xs text-gray-500 mt-1">Anda sudah dapat kembali</p>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Left Column: Riwayat Donor --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-900">Riwayat Donor</h2>
                        <a href="{{ route('pendonor.riwayat-donor') }}" class="text-sm text-red-600 hover:text-red-700 font-medium">
                            Lihat Detail
                        </a>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <th class="pb-3">Tanggal</th>
                                        <th class="pb-3">Kegiatan</th>
                                        <th class="pb-3">Lokasi</th>
                                        <th class="pb-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($riwayatDonasi ?? [] as $donasi)
                                    <tr class="text-sm">
                                        <td class="py-3 text-gray-900">{{ $donasi->tgl_donasi->format('d/m/Y') }}</td>
                                        <td class="py-3 text-gray-700">{{ $donasi->jenis_donor ?? 'Donor Darah Sukarela' }}</td>
                                        <td class="py-3 text-gray-700">{{ $donasi->lokasi_donor }}</td>
                                        <td class="py-3">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                {{ $donasi->status_donasi == 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $donasi->status_donasi }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="py-3 text-gray-900">17/9/2025</td>
                                        <td class="py-3 text-gray-700">Donor Darah Sukarela</td>
                                        <td class="py-3 text-gray-700">PMI Kota Makassar</td>
                                        <td class="py-3">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Selesai</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 text-gray-900">15/6/2025</td>
                                        <td class="py-3 text-gray-700">Donor Darah Kampus UNHAS</td>
                                        <td class="py-3 text-gray-700">Gedung Andi Pangerang UNHAS</td>
                                        <td class="py-3">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Selesai</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 text-gray-900">9/3/2025</td>
                                        <td class="py-3 text-gray-700">Donor Darah Masjid Raya</td>
                                        <td class="py-3 text-gray-700">Masjid Raya Makassar</td>
                                        <td class="py-3">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Selesai</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 text-gray-900">20/12/2024</td>
                                        <td class="py-3 text-gray-700">Donor Darah HUT Kemerdekaan</td>
                                        <td class="py-3 text-gray-700">Mall Panakkukang</td>
                                        <td class="py-3">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">Gagal</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 text-gray-900">15/9/2024</td>
                                        <td class="py-3 text-gray-700">Donor Darah Fakultas Kedokteran</td>
                                        <td class="py-3 text-gray-700">FK UNHAS</td>
                                        <td class="py-3">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Selesai</span>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Profile & Actions --}}
            <div class="space-y-6">
                
                {{-- Profile Card --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-red-600 rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-3">
                            {{ strtoupper(substr($pendonor->nama ?? Auth::user()->nama, 0, 1)) }}
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg">
                            {{ $pendonor->nama ?? 'Nama Pendonor' }}
                        </h3>
                        <p class="text-sm text-gray-600">
                            {{ $pendonor->golongan_darah ?? 'Golongan Darah' }} • Pendonor
                        </p>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            <span>Email:</span>
                            <span class="ml-auto font-medium">{{ $pendonor->email ?? 'donor@demo.com' }}</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <span>No. HP:</span>
                            <span class="ml-auto font-medium">{{ $pendonor->no_telepon ?? '08123456789' }}</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                            <span>Member sejak:</span>
                            <span class="ml-auto font-medium">{{ $pendonor->created_at ? $pendonor->created_at->format('Y') : '2024' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Pendonor Aktif Badge --}}
                <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-lg shadow-sm p-6 text-white text-center">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Pendonor Aktif</h3>
                    <p class="text-sm text-red-100">
                        Terima kasih telah menyumbangkan darah Anda. 
                        <br>5 nyawa berhasil diselamatkan!
                    </p>
                </div>

                {{-- Action Buttons --}}
               <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('kegiatan.index') }}" class="w-full flex items-center justify-center px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            Cari Kegiatan Donor
                        </a>
                        <a href="{{ route('pendonor.cek-kelayakan-donor') }}" class="w-full flex items-center justify-center px-4 py-3 bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                            Cek Kelayakan Donor
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection