{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\dev\partisipan-kegiatan.blade.php --}}
@extends('layouts.app')

@section('title', 'Partisipan - ' . $kegiatan->nama_kegiatan)

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 sm:py-8 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Back Button --}}
        <div class="mb-4 sm:mb-6">
            <a href="{{ route('managemen.kegiatan.index') }}" 
               class="inline-flex items-center text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Detail Kegiatan
            </a>
        </div>

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Partisipan</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $kegiatan->nama_kegiatan }}</p>
        </div>

        {{-- Success/Error Alerts --}}
        @if(session('success'))
        <div id="successAlert" class="mb-4 bg-green-100 border border-green-400 text-green-700 dark:bg-green-900/50 dark:border-green-700 dark:text-green-300 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div id="errorAlert" class="mb-4 bg-red-100 border border-red-400 text-red-700 dark:bg-red-900/50 dark:border-red-700 dark:text-red-300 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        {{-- Search Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('kegiatan.peserta.search', $kegiatan->kegiatan_id) }}" method="GET">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">Cari Partisipan</label>
                <div class="flex gap-3">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               name="search" 
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-white" 
                               placeholder="Cari berdasarkan nama..."
                               value="{{ $search ?? '' }}">
                    </div>
                    <button type="submit" class="px-8 py-2.5 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                        CARI
                    </button>
                </div>
            </form>
        </div>

        {{-- Daftar Partisipan --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Partisipan</h2>
            </div>
            
            {{-- Desktop Table --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Nama Pengguna</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Gol. Darah</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">No. HP</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Member</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($partisipans as $index => $partisipan)
                            @if($partisipan->pendonor && $partisipan->pendonor->user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                    {{ $partisipans->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $partisipan->pendonor->user->nama }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $golDarah = $partisipan->pendonor->golongan_darah ?? '-';
                                        $badgeColor = match(str_replace(['+', '-'], '', $golDarah)) {
                                            'A' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                            'B' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                            'AB' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                            'O' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                            default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-bold {{ $badgeColor }}">
                                        {{ $golDarah }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $partisipan->pendonor->user->email ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $partisipan->pendonor->user->no_telepon ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    {{ \Carbon\Carbon::parse($partisipan->created_at)->translatedFormat('F Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = match($partisipan->status_donasi) {
                                            'Berhasil' => ['color' => 'bg-green-600', 'text' => 'Berhasil'],
                                            'Terdaftar' => ['color' => 'bg-blue-600', 'text' => 'Terdaftar'],
                                            'Dibatalkan' => ['color' => 'bg-gray-500', 'text' => 'Dibatalkan'],
                                            default => ['color' => 'bg-gray-500', 'text' => 'Unknown']
                                        };
                                    @endphp
                                    <span class="inline-block px-3 py-1 rounded text-xs font-medium text-white {{ $statusConfig['color'] }}">
                                        {{ $statusConfig['text'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        @if($partisipan->status_donasi == 'Terdaftar')
                                            <button 
                                                onclick="openConfirmModal({{ $partisipan->donasi_id }})" 
                                                data-donasi-id="{{ $partisipan->donasi_id }}"
                                                class="px-4 py-2 bg-red-600 text-white text-xs font-semibold rounded-lg hover:bg-red-700 transition-colors">
                                                Donor
                                            </button>
                                        @else
                                            <button disabled 
                                                    class="px-4 py-2 bg-gray-400 text-white text-xs font-semibold rounded-lg cursor-not-allowed">
                                                Donor
                                            </button>
                                        @endif
                                        <a href="{{ route('admin.users.riwayat', $partisipan->pendonor_id) }}" 
                                           class="px-4 py-2 bg-gray-500 text-white text-xs font-semibold rounded-lg hover:bg-gray-600 transition-colors">
                                            Detail Pendonor
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada partisipan terdaftar</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="lg:hidden divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($partisipans as $index => $partisipan)
                    @if($partisipan->pendonor && $partisipan->pendonor->user)
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $partisipan->pendonor->user->nama }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $partisipan->pendonor->user->email }}</p>
                            </div>
                            @php
                                $statusConfig = match($partisipan->status_donasi) {
                                    'Berhasil' => ['color' => 'bg-green-600', 'text' => 'Berhasil'],
                                    'Terdaftar' => ['color' => 'bg-blue-600', 'text' => 'Terdaftar'],
                                    'Dibatalkan' => ['color' => 'bg-gray-500', 'text' => 'Dibatalkan'],
                                    default => ['color' => 'bg-gray-500', 'text' => 'Unknown']
                                };
                            @endphp
                            <span class="inline-block px-2 py-1 rounded text-xs font-medium text-white {{ $statusConfig['color'] }} ml-2">
                                {{ $statusConfig['text'] }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-2 mb-3 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Gol. Darah:</span>
                                @php
                                    $golDarah = $partisipan->pendonor->golongan_darah ?? '-';
                                    $badgeColor = match(str_replace(['+', '-'], '', $golDarah)) {
                                        'A' => 'bg-red-100 text-red-700',
                                        'B' => 'bg-purple-100 text-purple-700',
                                        'AB' => 'bg-blue-100 text-blue-700',
                                        'O' => 'bg-orange-100 text-orange-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                @endphp
                                <span class="inline-block px-2 py-0.5 rounded text-xs font-bold {{ $badgeColor }} ml-1">{{ $golDarah }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Member:</span>
                                <span class="text-gray-900 dark:text-white ml-1">{{ \Carbon\Carbon::parse($partisipan->created_at)->translatedFormat('M Y') }}</span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            @if($partisipan->status_donasi == 'Terdaftar')
                                <button 
                                    onclick="openConfirmModal({{ $partisipan->donasi_id }})" 
                                    data-donasi-id="{{ $partisipan->donasi_id }}"
                                    class="flex-1 px-3 py-2 bg-red-600 text-white text-xs font-semibold rounded-lg hover:bg-red-700">
                                    Donor
                                </button>
                            @else
                                <button disabled class="flex-1 px-3 py-2 bg-gray-400 text-white text-xs font-semibold rounded-lg cursor-not-allowed">
                                    Donor
                                </button>
                            @endif
                            <a href="{{ route('admin.users.riwayat', $partisipan->pendonor_id) }}" 
                               class="flex-1 px-3 py-2 bg-gray-500 text-white text-xs font-semibold rounded-lg hover:bg-gray-600 text-center">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                    @endif
                @empty
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <p class="text-gray-500 text-sm">Belum ada partisipan terdaftar</p>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($partisipans->hasPages())
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-center">
                    {{ $partisipans->links() }}
                </div>
            </div>
            @endif
        </div>

    </div>
</div>

{{-- Modal 1: Konfirmasi Kehadiran --}}
<div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full p-6 transform scale-95 opacity-0 transition-all duration-200" id="confirmModalContent">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900/30 mb-4">
                <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Konfirmasi Kehadiran</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                Apakah partisipan ini telah hadir dan siap untuk mendonor darah?
            </p>
            
            <div class="flex gap-3">
                <button type="button" onclick="showBloodTypeModal()" 
                        class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors">
                    Ya, Lanjutkan
                </button>
                <button type="button" onclick="closeConfirmModal()" 
                        class="flex-1 px-4 py-2.5 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-white font-medium rounded-lg transition-colors">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal 2: Pilih Jenis Darah --}}
<div id="bloodTypeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-lg w-full p-6 transform scale-95 opacity-0 transition-all duration-200" id="bloodTypeModalContent">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Pilih Jenis Darah</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
            Pilih jenis komponen darah yang akan didonorkan:
        </p>
        
        <form id="bloodTypeForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-3 mb-6">
                <label class="flex items-start p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:border-red-500 transition-all blood-type-option">
                    <input type="radio" name="jenis_darah" value="Darah Lengkap (Whole Blood)" class="mt-0.5 w-4 h-4 text-red-600 focus:ring-red-500" required>
                    <div class="ml-3 flex-1">
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">Darah Lengkap (Whole Blood)</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Darah utuh yang mengandung semua komponen</div>
                    </div>
                </label>

                <label class="flex items-start p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:border-red-500 transition-all blood-type-option">
                    <input type="radio" name="jenis_darah" value="Packed Red Cells (PRC)" class="mt-0.5 w-4 h-4 text-red-600 focus:ring-red-500" required>
                    <div class="ml-3 flex-1">
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">Packed Red Cells (PRC)</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Sel darah merah yang dipisahkan</div>
                    </div>
                </label>

                <label class="flex items-start p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:border-red-500 transition-all blood-type-option">
                    <input type="radio" name="jenis_darah" value="Trombosit (TC)" class="mt-0.5 w-4 h-4 text-red-600 focus:ring-red-500" required>
                    <div class="ml-3 flex-1">
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">Trombosit (TC)</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Komponen pembekuan darah</div>
                    </div>
                </label>

                <label class="flex items-start p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:border-red-500 transition-all blood-type-option">
                    <input type="radio" name="jenis_darah" value="Plasma" class="mt-0.5 w-4 h-4 text-red-600 focus:ring-red-500" required>
                    <div class="ml-3 flex-1">
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">Plasma</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Cairan darah tanpa sel darah</div>
                    </div>
                </label>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" 
                        class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors">
                    Konfirmasi
                </button>
                <button type="button" onclick="closeBloodTypeModal()" 
                        class="flex-1 px-4 py-2.5 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-white font-medium rounded-lg transition-colors">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let currentDonasiId = null;

function openConfirmModal(donasiId) {
    console.log('🔍 Opening confirm modal for donasi ID:', donasiId);
    
    if (!donasiId || donasiId === 'null' || donasiId === null || donasiId === undefined) {
        console.error('❌ INVALID DONASI ID:', donasiId);
        alert('Error: ID Donasi tidak valid!');
        return;
    }
    
    currentDonasiId = parseInt(donasiId);
    console.log('✅ currentDonasiId set to:', currentDonasiId);
    
    const modal = document.getElementById('confirmModal');
    const content = document.getElementById('confirmModalContent');
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeConfirmModal() {
    const modal = document.getElementById('confirmModal');
    const content = document.getElementById('confirmModalContent');
    
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => modal.classList.add('hidden'), 200);
}

function showBloodTypeModal() {
    console.log('🩸 Opening blood type modal');
    console.log('🩸 currentDonasiId:', currentDonasiId);
    
    if (!currentDonasiId || isNaN(currentDonasiId)) {
        console.error('❌ currentDonasiId invalid:', currentDonasiId);
        alert('Error: ID Donasi hilang!');
        return;
    }
    
    closeConfirmModal();
    
    const form = document.getElementById('bloodTypeForm');
    const updateUrl = `/donasi/${currentDonasiId}/update-status`;
    
    console.log('✅ Setting form action to:', updateUrl);
    form.action = updateUrl;
    
    const modal = document.getElementById('bloodTypeModal');
    const content = document.getElementById('bloodTypeModalContent');
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeBloodTypeModal() {
    const modal = document.getElementById('bloodTypeModal');
    const content = document.getElementById('bloodTypeModalContent');
    
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        document.querySelectorAll('input[name="jenis_darah"]').forEach(radio => radio.checked = false);
        document.querySelectorAll('.blood-type-option').forEach(label => {
            label.classList.remove('border-red-500', 'bg-red-50', 'dark:bg-red-900/10');
        });
        currentDonasiId = null;
    }, 200);
}

document.getElementById('bloodTypeForm')?.addEventListener('submit', function(e) {
    const selectedJenisDarah = document.querySelector('input[name="jenis_darah"]:checked');
    if (!selectedJenisDarah) {
        e.preventDefault();
        alert('⚠️ Pilih jenis darah terlebih dahulu!');
        return false;
    }
});

document.querySelectorAll('.blood-type-option input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.blood-type-option').forEach(label => {
            label.classList.remove('border-red-500', 'bg-red-50', 'dark:bg-red-900/10');
        });
        
        if(this.checked) {
            this.closest('.blood-type-option').classList.add('border-red-500', 'bg-red-50', 'dark:bg-red-900/10');
        }
    });
});

setTimeout(() => {
    ['successAlert', 'errorAlert'].forEach(id => {
        const alert = document.getElementById(id);
        if(alert) {
            alert.style.transition = 'opacity 0.3s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }
    });
}, 5000);

['confirmModal', 'bloodTypeModal'].forEach(modalId => {
    document.getElementById(modalId)?.addEventListener('click', function(e) {
        if(e.target === this) {
            modalId === 'confirmModal' ? closeConfirmModal() : closeBloodTypeModal();
        }
    });
});

document.addEventListener('keydown', function(e) {
    if(e.key === 'Escape') {
        closeConfirmModal();
        closeBloodTypeModal();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('[data-donasi-id]');
    console.log('🔍 Total buttons:', buttons.length);
    buttons.forEach((btn, i) => {
        console.log(`   Button ${i + 1}: ID = ${btn.getAttribute('data-donasi-id')}`);
    });
});
</script>
@endpush
@endsection