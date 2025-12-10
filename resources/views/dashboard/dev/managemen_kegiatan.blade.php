{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\dev\managemen_kegiatan.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Kegiatan - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Manajemen Kegiatan</h1>
            <p class="text-gray-600 mt-1">Kelola semua kegiatan donor darah</p>
        </div>

        {{-- Search and Add Button --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Cari Kegiatan</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                        <input type="text" 
                               id="searchInput"
                               placeholder="Cari berdasarkan nama atau lokasi..." 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                </div>
                <div class="md:mt-6">
                    <button onclick="openModal()" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-colors whitespace-nowrap">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Kegiatan Baru
                    </button>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Nama Kegiatan
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Lokasi
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Partisipan
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                        @forelse($kegiatan as $item)
                        <tr class="hover:bg-gray-50 transition-colors" data-search="{{ strtolower($item->nama_kegiatan . ' ' . $item->lokasi) }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ $item->nama_kegiatan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $item->tanggal_formatted }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $item->lokasi }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->status_color === 'blue')
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-700">
                                        {{ $item->status_label }}
                                    </span>
                                @elseif($item->status_color === 'green')
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">
                                        {{ $item->status_label }}
                                    </span>
                                @elseif($item->status_color === 'red')
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700">
                                        {{ $item->status_label }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-700">
                                        {{ $item->status_label }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ $item->partisipan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    {{-- View --}}
                                    <a href="{{ route('kegiatan.show', $item->kegiatan_id) }}" 
                                       class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                       title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    {{-- Edit --}}
                                    <button onclick="openEditModal({{ $item->kegiatan_id }})" 
                                       class="p-2 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                       title="Edit Kegiatan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada data kegiatan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Buat Kegiatan Baru --}}
<div id="modalKegiatan" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-0 mx-auto h-full w-full max-w-md bg-white flex flex-col">
        {{-- Header - Fixed --}}
        <div class="flex-shrink-0 bg-white border-b border-gray-200 px-5 py-4 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Buat Kegiatan Donor baru</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Form Content - Scrollable --}}
        <div class="flex-1 overflow-y-auto px-5 py-4">
            <form action="{{ route('managemen.kegiatan.store') }}" method="POST" id="formKegiatan">
                @csrf
                
                {{-- Nama Kegiatan --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Nama Kegiatan <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                           name="nama_kegiatan" 
                           placeholder="Donor Darah Kampus UNHAS"
                           required
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                </div>

                {{-- Tanggal --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Tanggal <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                        <input type="date" 
                            name="tanggal" 
                            id="tanggal"
                            required
                            class="w-full px-4 py-2.5 pr-12 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Waktu Mulai dan Selesai --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Waktu mulai <span class="text-red-600">*</span>
                        </label>
                        <div class="relative">
                            <input type="time" 
                                name="waktu_mulai" 
                                required
                                class="w-full px-4 py-2.5 pr-12 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Waktu selesai <span class="text-red-600">*</span>
                        </label>
                        <div class="relative">
                            <input type="time" 
                                name="waktu_selesai" 
                                required
                                class="w-full px-4 py-2.5 pr-12 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Lokasi --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Lokasi <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                            name="lokasi" 
                            id="lokasiInput"
                            placeholder="Ketik nama lokasi..."
                            required
                            autocomplete="off"
                            class="w-full px-4 py-2.5 pr-10 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                        <button type="button"
                                onclick="openMapPopup(false)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </button>
                    </div>
                    
                    {{-- Autocomplete Dropdown --}}
                    <div id="locationDropdown" class="hidden relative z-20 w-full mt-2 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        {{-- Dropdown items akan diisi via JavaScript --}}
                    </div>
                    
                    {{-- Map Preview (Read Only) --}}
                    <div class="mt-2 h-48 bg-gray-100 border border-gray-200 rounded-lg overflow-hidden relative">
                        <div id="mapPreview" class="w-full h-full"></div>
                        <div class="absolute inset-0 bg-transparent cursor-not-allowed"></div>
                    </div>
                    
                    {{-- Address Display --}}
                    <div class="mt-2 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                        <p class="text-xs text-gray-600 font-medium" id="selectedAddress">
                            Pilih lokasi dari pencarian atau klik icon pensil
                        </p>
                    </div>
                    
                    {{-- Hidden coordinates --}}
                    <input type="hidden" name="latitude" id="latitude" value="">
                    <input type="hidden" name="longitude" id="longitude" value="">
                </div>

                {{-- ✅ RINCIAN LOKASI (TERPISAH DARI DIV LOKASI) --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Rincian Lokasi
                    </label>
                    <input type="text" 
                        name="rincian_lokasi" 
                        id="rincianLokasi"
                        placeholder="Ruangan 101, Lantai 3B"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                    <p class="text-xs text-gray-500 mt-1">Detail lokasi seperti nama ruangan, lantai, atau area spesifik</p>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" 
                              rows="3" 
                              placeholder="Deskripsi kegiatan..."
                              class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm resize-none"></textarea>
                </div>

                {{-- Hidden fields --}}
                <input type="hidden" name="status" value="Planned">
                <input type="hidden" name="target_donor" value="0">
            </form>
        </div>

        {{-- Footer - Fixed --}}
        <div class="flex-shrink-0 border-t border-gray-200 px-5 py-4 bg-white">
            <div class="grid grid-cols-2 gap-3">
                <button type="button" 
                        onclick="closeModal()"
                        class="px-4 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors text-sm">
                    Batal
                </button>
                <button type="submit" 
                        form="formKegiatan"
                        class="px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors text-sm">
                    Buat Kegiatan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Kegiatan --}}
<div id="modalEditKegiatan" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-0 mx-auto h-full w-full max-w-md bg-white flex flex-col">
        {{-- Header - Fixed --}}
        <div class="flex-shrink-0 bg-white border-b border-gray-200 px-5 py-4 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Edit Kegiatan Donor</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Form Content - Scrollable --}}
        <div class="flex-1 overflow-y-auto px-5 py-4">
            <form id="formEditKegiatan" method="POST">
                @csrf
                @method('PUT')
                
                {{-- Nama Kegiatan --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Nama Kegiatan <span class="text-red-600">*</span>
                    </label>
                    <input type="text" 
                           name="nama_kegiatan" 
                           id="edit_nama_kegiatan"
                           placeholder="Donor Darah Kampus UNHAS"
                           required
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                </div>

                {{-- Tanggal --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Tanggal <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                        <input type="date" 
                            name="tanggal" 
                            id="edit_tanggal"
                            required
                            class="w-full px-4 py-2.5 pr-12 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Waktu Mulai dan Selesai --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Waktu mulai <span class="text-red-600">*</span>
                        </label>
                        <div class="relative">
                            <input type="time" 
                                name="waktu_mulai" 
                                id="edit_waktu_mulai"
                                required
                                class="w-full px-4 py-2.5 pr-12 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            Waktu selesai <span class="text-red-600">*</span>
                        </label>
                        <div class="relative">
                            <input type="time" 
                                name="waktu_selesai" 
                                id="edit_waktu_selesai"
                                required
                                class="w-full px-4 py-2.5 pr-12 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Lokasi --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Lokasi <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                            name="lokasi" 
                            id="edit_lokasiInput"
                            placeholder="Ketik nama lokasi..."
                            required
                            autocomplete="off"
                            class="w-full px-4 py-2.5 pr-10 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                        <button type="button"
                                onclick="openMapPopup(true)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </button>
                    </div>
                    
                    {{-- Autocomplete Dropdown --}}
                    <div id="edit_locationDropdown" class="hidden relative z-20 w-full mt-2 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        {{-- Dropdown items akan diisi via JavaScript --}}
                    </div>
                    
                    {{-- Map Preview (Read Only) --}}
                    <div class="mt-2 h-48 bg-gray-100 border border-gray-200 rounded-lg overflow-hidden relative">
                        <div id="edit_mapPreview" class="w-full h-full"></div>
                        <div class="absolute inset-0 bg-transparent cursor-not-allowed"></div>
                    </div>
                    
                    {{-- Address Display --}}
                    <div class="mt-2 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                        <p class="text-xs text-gray-600 font-medium" id="edit_selectedAddress">
                            Pilih lokasi dari pencarian atau klik icon pensil
                        </p>
                    </div>
                    
                    {{-- Hidden coordinates --}}
                    <input type="hidden" name="latitude" id="edit_latitude" value="">
                    <input type="hidden" name="longitude" id="edit_longitude" value="">
                </div>

                {{-- ✅ RINCIAN LOKASI (TERPISAH DARI DIV LOKASI) --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Rincian Lokasi
                    </label>
                    <input type="text" 
                        name="rincian_lokasi" 
                        id="edit_rincianLokasi"
                        placeholder="Ruangan 101, Lantai 3B"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                    <p class="text-xs text-gray-500 mt-1">Detail lokasi seperti nama ruangan, lantai, atau area spesifik</p>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" 
                              id="edit_deskripsi"
                              rows="3" 
                              placeholder="Deskripsi kegiatan..."
                              class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm resize-none"></textarea>
                </div>

                {{-- Hidden fields --}}
                <input type="hidden" name="target_donor" id="edit_target_donor" value="0">
                <input type="hidden" name="status" id="edit_status" value="">
            </form>
        </div>

        {{-- Footer - Fixed --}}
        <div class="flex-shrink-0 border-t border-gray-200 px-5 py-4 bg-white">
            <div class="grid grid-cols-2 gap-3">
                <button type="button" 
                        onclick="closeEditModal()"
                        class="px-4 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors text-sm">
                    Batal
                </button>
                <button type="submit" 
                        form="formEditKegiatan"
                        class="px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors text-sm">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ✅ LOADING MODAL --}}
<div id="loadingModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 overflow-y-auto h-full w-full z-50">
    <div class="relative top-1/3 mx-auto w-full max-w-sm">
        <div class="flex flex-col items-center justify-center">
            {{-- Animated Logo/Spinner --}}
            <div class="relative mb-8">
                {{-- Outer rotating ring --}}
                <div class="w-24 h-24 border-4 border-red-200 border-t-red-600 rounded-full animate-spin"></div>
                {{-- Inner pulsing circle --}}
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <div class="w-16 h-16 bg-red-600 rounded-full animate-pulse flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            {{-- Loading Text --}}
            <div class="text-center">
                <h3 class="text-xl font-bold text-white mb-2" id="loadingText">Menyimpan Data...</h3>
                <p class="text-sm text-gray-300">Mohon tunggu sebentar</p>
            </div>
        </div>
    </div>
</div>

{{-- ✅ SUCCESS MODAL --}}
<div id="successModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-1/4 mx-auto p-8 border w-full max-w-sm shadow-lg rounded-2xl bg-white">
        <div class="text-center">
            {{-- Success Icon with Animation --}}
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-white border-4 border-green-500 mb-6 animate-bounce">
                <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            
            {{-- Success Message --}}
            <h3 class="text-xl font-bold text-gray-900 mb-2" id="successMessage">Kegiatan Berhasil Dibuat!</h3>
            <p class="text-sm text-gray-600">Halaman akan dimuat ulang...</p>
        </div>
    </div>
</div>

{{-- Popup Map Modal (Fullscreen) --}}
<div id="mapPopup" class="hidden fixed inset-0 bg-black bg-opacity-75 z-[100] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-4xl h-[80vh] flex flex-col">
        {{-- Header --}}
        <div class="flex-shrink-0 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Pilih Lokasi di Peta</h3>
            <button onclick="closeMapPopup()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        {{-- Search in Popup --}}
        <div class="flex-shrink-0 px-6 py-4 border-b border-gray-200">
            <div class="relative">
                <input type="text" 
                       id="popupSearchInput"
                       placeholder="Cari lokasi di peta..."
                       class="w-full px-4 py-2.5 pr-10 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                <svg class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            
            {{-- Search Results Dropdown --}}
            <div id="popupDropdown" class="hidden mt-2 bg-white border border-gray-300 rounded-lg shadow-lg max-h-48 overflow-y-auto">
                {{-- Search results akan diisi via JavaScript --}}
            </div>
        </div>
        
        {{-- Map Container --}}
        <div class="flex-1 p-6">
            <div id="interactiveMap" class="w-full h-full rounded-xl border-2 border-gray-300"></div>
        </div>
        
        {{-- Footer --}}
        <div class="flex-shrink-0 px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between mb-3">
                <div class="flex-1">
                    <p class="text-xs text-gray-500 mb-1">Lokasi Terpilih:</p>
                    <p class="text-sm font-semibold text-gray-900" id="popupSelectedAddress">-</p>
                </div>
            </div>
            <div class="flex gap-3">
                <button type="button" 
                        onclick="closeMapPopup()"
                        class="flex-1 px-4 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="button" 
                        onclick="confirmMapLocation()"
                        class="flex-1 px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                    Gunakan Lokasi Ini
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #mapPreview, #edit_mapPreview { 
        height: 192px;
        width: 100%;
    }
    #interactiveMap {
        height: 100%;
        width: 100%;
    }
    
    /* ✅ Fix untuk icon kalender dan jam agar tidak tertutup */
    input[type="date"]::-webkit-calendar-picker-indicator,
    input[type="time"]::-webkit-calendar-picker-indicator {
        position: absolute;
        right: 8px;
        opacity: 0;
        cursor: pointer;
        width: 20px;
        height: 20px;
        z-index: 2;
    }
    
    /* Sembunyikan icon default browser */
    input[type="date"]::-webkit-inner-spin-button,
    input[type="date"]::-webkit-clear-button,
    input[type="time"]::-webkit-inner-spin-button,
    input[type="time"]::-webkit-clear-button {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Kegiatan data untuk edit
    const kegiatanData = @json($kegiatan);

    // Simple search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#tableBody tr[data-search]');
        
        rows.forEach(row => {
            const searchText = row.getAttribute('data-search');
            if (searchText.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Modal Create functions
    function openModal() {
        document.getElementById('modalKegiatan').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('modalKegiatan').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('formKegiatan').reset();
    }

    // Modal Edit functions
    openEditModal = function(id) {
        const kegiatan = kegiatanData.find(k => k.kegiatan_id === id);
        
        if (!kegiatan) {
            alert('Data kegiatan tidak ditemukan');
            return;
        }

        // ✅ FORMAT TANGGAL KE YYYY-MM-DD (format input date)
        let formattedDate = kegiatan.tanggal;
        if (formattedDate && !formattedDate.match(/^\d{4}-\d{2}-\d{2}$/)) {
            const date = new Date(formattedDate);
            if (!isNaN(date.getTime())) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                formattedDate = `${year}-${month}-${day}`;
            }
        }

        // Populate form
        document.getElementById('edit_nama_kegiatan').value = kegiatan.nama_kegiatan;
        document.getElementById('edit_tanggal').value = formattedDate;
        document.getElementById('edit_waktu_mulai').value = kegiatan.waktu_mulai;
        document.getElementById('edit_waktu_selesai').value = kegiatan.waktu_selesai;
        document.getElementById('edit_lokasiInput').value = kegiatan.lokasi;
        document.getElementById('edit_rincianLokasi').value = kegiatan.rincian_lokasi || ''; // ✅ INI
        document.getElementById('edit_latitude').value = kegiatan.latitude || '';
        document.getElementById('edit_longitude').value = kegiatan.longitude || '';
        document.getElementById('edit_selectedAddress').textContent = kegiatan.lokasi;
        document.getElementById('edit_deskripsi').value = kegiatan.deskripsi || '';
        document.getElementById('edit_status').value = kegiatan.status;
        document.getElementById('edit_target_donor').value = kegiatan.target_donor || 0;

        // Set form action URL
        const form = document.getElementById('formEditKegiatan');
        form.action = `/managemen-kegiatan/${id}`;

        document.getElementById('modalEditKegiatan').classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Initialize preview map
        setTimeout(() => {
            initPreviewMap(true);
            if (kegiatan.latitude && kegiatan.longitude) {
                editMapPreview.setView([kegiatan.latitude, kegiatan.longitude], 15);
                editPreviewMarker.setLatLng([kegiatan.latitude, kegiatan.longitude]);
            }
        }, 100);
    };

    function closeEditModal() {
        document.getElementById('modalEditKegiatan').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('formEditKegiatan').reset();
    }

    // Success modal functions
    function showSuccessModal(message = 'Kegiatan Berhasil Dibuat!') {
        document.getElementById('successMessage').textContent = message;
        document.getElementById('successModal').classList.remove('hidden');
        
        // Auto reload after 2 seconds
        setTimeout(function() {
            window.location.reload();
        }, 2000);
    }

    function closeSuccessModal() {
        document.getElementById('successModal').classList.add('hidden');
    }

    // Close modals when clicking outside
    document.getElementById('modalKegiatan').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    document.getElementById('modalEditKegiatan').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });

    document.getElementById('successModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeSuccessModal();
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const loadingModal = document.getElementById('loadingModal');
            const successModal = document.getElementById('successModal');
            
            // Jangan tutup modal jika sedang loading atau success
            if (!loadingModal.classList.contains('hidden') || !successModal.classList.contains('hidden')) {
                return;
            }
            
            closeModal();
            closeEditModal();
        }
    });

    // ✅ HANDLE FORM CREATE SUBMISSION WITH LOADING
    document.getElementById('formKegiatan').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // 1. Tutup modal form
        document.getElementById('modalKegiatan').classList.add('hidden');
        
        // 2. Tampilkan loading modal
        document.getElementById('loadingText').textContent = 'Menyimpan Data...';
        document.getElementById('loadingModal').classList.remove('hidden');
        
        // 3. Submit form
        this.submit();
    });

    // ✅ HANDLE FORM EDIT SUBMISSION WITH LOADING
    document.getElementById('formEditKegiatan').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // 1. Tutup modal form
        document.getElementById('modalEditKegiatan').classList.add('hidden');
        
        // 2. Tampilkan loading modal
        document.getElementById('loadingText').textContent = 'Mengupdate Data...';
        document.getElementById('loadingModal').classList.remove('hidden');
        
        // 3. Submit form
        this.submit();
    });

    // ✅ CHECK FOR SUCCESS MESSAGE FROM SERVER
    @if(session('success'))
        // Hide loading modal
        document.getElementById('loadingModal').classList.add('hidden');
        
        // Show success modal
        showSuccessModal('{{ session('success') }}');
    @endif

    // ✅ CHECK FOR ERROR MESSAGE FROM SERVER
    @if(session('error') || $errors->any())
        // Hide loading modal if any
        document.getElementById('loadingModal').classList.add('hidden');
        
        // Show error alert
        alert('Terjadi kesalahan: {{ session("error") ?? $errors->first() }}');
    @endif

    let mapPreview = null;
    let editMapPreview = null;
    let interactiveMap = null;
    let previewMarker = null;
    let editPreviewMarker = null;
    let interactiveMarker = null;
    
    let isEditMode = false;
    let tempLocation = { lat: null, lng: null, address: '' };

    // Default location (Makassar)
    const defaultLat = -5.1348;
    const defaultLng = 119.4891;

    // ✅ DEBOUNCE FUNCTION
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // ✅ INIT PREVIEW MAPS (READ ONLY)
    function initPreviewMap(isEdit = false) {
        const mapId = isEdit ? 'edit_mapPreview' : 'mapPreview';
        const mapInstance = isEdit ? editMapPreview : mapPreview;
        
        if (mapInstance) {
            mapInstance.remove();
        }

        const map = L.map(mapId, {
            dragging: false,
            touchZoom: false,
            scrollWheelZoom: false,
            doubleClickZoom: false,
            boxZoom: false,
            keyboard: false,
            zoomControl: false
        }).setView([defaultLat, defaultLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const marker = L.marker([defaultLat, defaultLng], {
            icon: L.icon({
                iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41]
            })
        }).addTo(map);

        if (isEdit) {
            editMapPreview = map;
            editPreviewMarker = marker;
        } else {
            mapPreview = map;
            previewMarker = marker;
        }
    }

    // ✅ INIT INTERACTIVE MAP (IN POPUP)
    function initInteractiveMap() {
        if (interactiveMap) {
            interactiveMap.remove();
        }

        const initialLat = tempLocation.lat || defaultLat;
        const initialLng = tempLocation.lng || defaultLng;

        interactiveMap = L.map('interactiveMap').setView([initialLat, initialLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(interactiveMap);

        interactiveMarker = L.marker([initialLat, initialLng], {
            draggable: true,
            icon: L.icon({
                iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41]
            })
        }).addTo(interactiveMap);

        // Update on marker drag
        interactiveMarker.on('dragend', function(e) {
            const position = interactiveMarker.getLatLng();
            reverseGeocode(position.lat, position.lng, true);
        });

        // Update on map click
        interactiveMap.on('click', function(e) {
            interactiveMarker.setLatLng(e.latlng);
            reverseGeocode(e.latlng.lat, e.latlng.lng, true);
        });

        // Set initial address
        if (tempLocation.address) {
            document.getElementById('popupSelectedAddress').textContent = tempLocation.address;
        } else {
            reverseGeocode(initialLat, initialLng, true);
        }
    }

    // ✅ REVERSE GEOCODING
    function reverseGeocode(lat, lng, isPopup = false) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(response => response.json())
            .then(data => {
                const address = data.display_name || 'Lokasi tidak diketahui';
                
                if (isPopup) {
                    tempLocation = { lat, lng, address };
                    document.getElementById('popupSelectedAddress').textContent = address;
                } else {
                    updateLocationDisplay(lat, lng, address);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const coords = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                
                if (isPopup) {
                    tempLocation = { lat, lng, address: coords };
                    document.getElementById('popupSelectedAddress').textContent = coords;
                } else {
                    updateLocationDisplay(lat, lng, coords);
                }
            });
    }

    // ✅ UPDATE LOCATION DISPLAY
    function updateLocationDisplay(lat, lng, address) {
        const prefix = isEditMode ? 'edit_' : '';
        
        // Update inputs
        document.getElementById(prefix + 'latitude').value = lat;
        document.getElementById(prefix + 'longitude').value = lng;
        document.getElementById(prefix + 'lokasiInput').value = address;
        document.getElementById(prefix + 'selectedAddress').textContent = address;
        
        // Update preview map
        const map = isEditMode ? editMapPreview : mapPreview;
        const marker = isEditMode ? editPreviewMarker : previewMarker;
        
        if (map && marker) {
            map.setView([lat, lng], 15);
            marker.setLatLng([lat, lng]);
        }
    }

    // ✅ SEARCH LOCATION (AUTOCOMPLETE)
    const searchLocation = debounce(function(query, isEdit = false, isPopup = false) {
        if (query.length < 3) {
            hideDropdown(isEdit, isPopup);
            return;
        }

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5`)
            .then(response => response.json())
            .then(data => {
                showDropdown(data, isEdit, isPopup);
            })
            .catch(error => {
                console.error('Error:', error);
                hideDropdown(isEdit, isPopup);
            });
    }, 500);

    // ✅ SHOW DROPDOWN
    function showDropdown(results, isEdit = false, isPopup = false) {
        let dropdownId;
        
        if (isPopup) {
            dropdownId = 'popupDropdown';
        } else {
            dropdownId = isEdit ? 'edit_locationDropdown' : 'locationDropdown';
        }
        
        const dropdown = document.getElementById(dropdownId);
        
        if (results.length === 0) {
            dropdown.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500">Tidak ada hasil</div>';
            dropdown.classList.remove('hidden');
            return;
        }

        dropdown.innerHTML = results.map(result => `
            <div class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-0"
                 onclick="selectLocation(${result.lat}, ${result.lon}, '${result.display_name.replace(/'/g, "\\'")}', ${isEdit}, ${isPopup})">
                <div class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">${result.display_name}</p>
                    </div>
                </div>
            </div>
        `).join('');
        
        dropdown.classList.remove('hidden');
    }

    // ✅ HIDE DROPDOWN
    function hideDropdown(isEdit = false, isPopup = false) {
        let dropdownId;
        
        if (isPopup) {
            dropdownId = 'popupDropdown';
        } else {
            dropdownId = isEdit ? 'edit_locationDropdown' : 'locationDropdown';
        }
        
        const dropdown = document.getElementById(dropdownId);
        dropdown.classList.add('hidden');
    }

    // ✅ SELECT LOCATION FROM DROPDOWN
    function selectLocation(lat, lng, address, isEdit = false, isPopup = false) {
        if (isPopup) {
            // Update popup map
            if (interactiveMap && interactiveMarker) {
                interactiveMap.setView([lat, lng], 15);
                interactiveMarker.setLatLng([lat, lng]);
                tempLocation = { lat, lng, address };
                document.getElementById('popupSelectedAddress').textContent = address;
            }
            hideDropdown(isEdit, true);
        } else {
            // Update preview directly
            updateLocationDisplay(lat, lng, address);
            hideDropdown(isEdit, false);
        }
    }

    // ✅ OPEN MAP POPUP
    function openMapPopup(isEdit = false) {
        isEditMode = isEdit;
        const prefix = isEdit ? 'edit_' : '';
        
        // Get current location if exists
        const lat = parseFloat(document.getElementById(prefix + 'latitude').value) || defaultLat;
        const lng = parseFloat(document.getElementById(prefix + 'longitude').value) || defaultLng;
        const address = document.getElementById(prefix + 'lokasiInput').value || '';
        
        tempLocation = { lat, lng, address };
        
        document.getElementById('mapPopup').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
            initInteractiveMap();
            interactiveMap.invalidateSize();
        }, 100);
    }

    // ✅ CLOSE MAP POPUP
    function closeMapPopup() {
        document.getElementById('mapPopup').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('popupSearchInput').value = '';
        hideDropdown(false, true);
    }

    // ✅ CONFIRM MAP LOCATION
    function confirmMapLocation() {
        if (!tempLocation.lat || !tempLocation.lng) {
            alert('Pilih lokasi terlebih dahulu');
            return;
        }
        
        updateLocationDisplay(tempLocation.lat, tempLocation.lng, tempLocation.address);
        closeMapPopup();
    }

    // ✅ EVENT LISTENERS FOR LOCATION INPUT
    document.getElementById('lokasiInput').addEventListener('input', function(e) {
        searchLocation(e.target.value, false, false);
    });

    document.getElementById('edit_lokasiInput').addEventListener('input', function(e) {
        searchLocation(e.target.value, true, false);
    });

    document.getElementById('popupSearchInput').addEventListener('input', function(e) {
        searchLocation(e.target.value, false, true);
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#lokasiInput') && !e.target.closest('#locationDropdown')) {
            hideDropdown(false, false);
        }
        if (!e.target.closest('#edit_lokasiInput') && !e.target.closest('#edit_locationDropdown')) {
            hideDropdown(true, false);
        }
        if (!e.target.closest('#popupSearchInput') && !e.target.closest('#popupDropdown')) {
            hideDropdown(false, true);
        }
    });

    // ✅ UPDATE OPEN MODAL FUNCTIONS
    const originalOpenModal = openModal;
    openModal = function() {
        originalOpenModal();
        setTimeout(() => {
            initPreviewMap(false);
        }, 100);
    };

    const originalOpenEditModal = openEditModal;
    openEditModal = function(id) {
        const kegiatan = kegiatanData.find(k => k.kegiatan_id === id);
        
        if (!kegiatan) {
            alert('Data kegiatan tidak ditemukan');
            return;
        }

        // ✅ FORMAT TANGGAL KE YYYY-MM-DD (format input date)
        let formattedDate = kegiatan.tanggal;
        if (formattedDate && !formattedDate.match(/^\d{4}-\d{2}-\d{2}$/)) {
            const date = new Date(formattedDate);
            if (!isNaN(date.getTime())) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                formattedDate = `${year}-${month}-${day}`;
            }
        }

        // Populate form
        document.getElementById('edit_nama_kegiatan').value = kegiatan.nama_kegiatan;
        document.getElementById('edit_tanggal').value = formattedDate;
        document.getElementById('edit_waktu_mulai').value = kegiatan.waktu_mulai;
        document.getElementById('edit_waktu_selesai').value = kegiatan.waktu_selesai;
        document.getElementById('edit_lokasiInput').value = kegiatan.lokasi;
        document.getElementById('edit_rincianLokasi').value = kegiatan.rincian_lokasi || ''; // ✅ TAMBAH
        document.getElementById('edit_latitude').value = kegiatan.latitude || '';
        document.getElementById('edit_longitude').value = kegiatan.longitude || '';
        document.getElementById('edit_selectedAddress').textContent = kegiatan.lokasi;
        document.getElementById('edit_deskripsi').value = kegiatan.deskripsi || '';
        document.getElementById('edit_status').value = kegiatan.status;
        document.getElementById('edit_target_donor').value = kegiatan.target_donor || 0;

        // Set form action URL
        const form = document.getElementById('formEditKegiatan');
        form.action = `/managemen-kegiatan/${id}`;

        document.getElementById('modalEditKegiatan').classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Initialize preview map
        setTimeout(() => {
            initPreviewMap(true);
            if (kegiatan.latitude && kegiatan.longitude) {
                editMapPreview.setView([kegiatan.latitude, kegiatan.longitude], 15);
                editPreviewMarker.setLatLng([kegiatan.latitude, kegiatan.longitude]);
            }
        }, 100);
    };
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map, #editMap { 
        height: 250px; 
        width: 100%; 
        border-radius: 0.75rem;
        margin-top: 0.5rem;
    }
</style>
@endpush
@endsection