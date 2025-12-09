{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\dev\managemen-permintaan-darurat.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Permintaan Donor - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Permintaan Donor</h1>
            <p class="text-gray-600 mt-1">Kelola semua permintaan donor darah dari masyarakat</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            {{-- Total Permintaan --}}
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <p class="text-xs text-gray-600 mb-1">Total Permintaan</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalPermintaan }}</p>
            </div>

            {{-- Darurat --}}
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <p class="text-xs text-gray-600 mb-1">Darurat</p>
                <p class="text-3xl font-bold text-red-600">{{ $darurat }}</p>
            </div>

            {{-- Baru --}}
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <p class="text-xs text-gray-600 mb-1">Baru</p>
                <p class="text-3xl font-bold text-blue-600">{{ $belumTerpenuhi }}</p>
            </div>

            {{-- Diproses --}}
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <p class="text-xs text-gray-600 mb-1">Diproses</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $diproses }}</p>
            </div>

            {{-- Terpenuhi --}}
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <p class="text-xs text-gray-600 mb-1">Terpenuhi</p>
                <p class="text-3xl font-bold text-green-600">{{ $terpenuhi }}</p>
            </div>
        </div>

        {{-- Search and Filter --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <form method="GET" action="{{ route('managemen.permintaan-darurat.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Search --}}
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Cari Permintaan</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                        <input type="text" 
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari nama pasien atau golongan darah..." 
                               class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                </div>

                {{-- Filter Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Filter Status</label>
                    <select name="status" 
                            onchange="this.form.submit()"
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="Requesting" {{ request('status') == 'Requesting' ? 'selected' : '' }}>Requesting</option>
                        <option value="Responded" {{ request('status') == 'Responded' ? 'selected' : '' }}>Responded</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                {{-- Filter Tingkat Urgensi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-2">Filter Tingkat Urgensi</label>
                    <select name="urgensi" 
                            onchange="this.form.submit()"
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <option value="">Semua Tingkat Urgensi</option>
                        <option value="Sangat Mendesak" {{ request('urgensi') == 'Sangat Mendesak' ? 'selected' : '' }}>Sangat Mendesak</option>
                        <option value="Mendesak" {{ request('urgensi') == 'Mendesak' ? 'selected' : '' }}>Mendesak</option>
                        <option value="Normal" {{ request('urgensi') == 'Normal' ? 'selected' : '' }}>Normal</option>
                    </select>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Pasien</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Gol. Darah</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Rumah Sakit</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tingkatan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($permintaan as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $item->nomor_pelacakan }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->nama_pasien }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-xs font-bold rounded-md
                                    @if(in_array($item->gol_darah, ['A+', 'A-'])) bg-red-100 text-red-700
                                    @elseif(in_array($item->gol_darah, ['B+', 'B-'])) bg-orange-100 text-orange-700
                                    @elseif(in_array($item->gol_darah, ['O+', 'O-'])) bg-yellow-100 text-yellow-700
                                    @else bg-purple-100 text-purple-700
                                    @endif">
                                    {{ $item->gol_darah }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->jumlah_kantong }} kantong
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ Str::limit($item->tempat_rawat, 25) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->tingkat_urgensi == 'Sangat Mendesak')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-red-100 text-red-700">
                                        Sangat Mendesak
                                    </span>
                                @elseif($item->tingkat_urgensi == 'Mendesak')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-yellow-100 text-yellow-700">
                                        Mendesak
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-green-100 text-green-700">
                                        Normal
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->status_permintaan == 'Requesting')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-purple-100 text-purple-700">
                                        Requesting
                                    </span>
                                @elseif($item->status_permintaan == 'Responded')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-indigo-100 text-indigo-700">
                                        Responded
                                    </span>
                                @elseif($item->status_permintaan == 'Pending')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-blue-100 text-blue-700">
                                        Pending
                                    </span>
                                @elseif($item->status_permintaan == 'Approved')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-yellow-100 text-yellow-700">
                                        Approved
                                    </span>
                                @elseif($item->status_permintaan == 'Completed')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-green-100 text-green-700">
                                        Completed
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-gray-100 text-gray-700">
                                        Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    {{-- View Detail --}}
                                    <button onclick="showDetail({{ $item->permintaan_id }})"
                                       class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                       title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-gray-500 text-sm">Tidak ada data permintaan donor</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($permintaan->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $permintaan->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal Detail Permintaan --}}
<div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[95vh] overflow-hidden flex flex-col">
        {{-- Header - Fixed --}}
        <div class="flex-shrink-0 bg-white border-b border-gray-200 px-5 py-4 flex items-center justify-between">
            <h3 class="text-base font-bold text-gray-900">Detail Permintaan Donor</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Content - Scrollable --}}
        <div id="modalContent" class="flex-1 overflow-y-auto px-5 py-4">
            {{-- Content will be loaded here --}}
        </div>
    </div>
</div>

{{-- ✅ TAMBAHAN: Modal Konfirmasi Proses --}}
<div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-8 relative">
        {{-- Close Button --}}
        <button onclick="closeConfirmModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="text-center">
            {{-- Icon Question --}}
            <div class="w-24 h-24 bg-white border-2 border-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            {{-- Text --}}
            <h3 class="text-xl font-bold text-gray-900 mb-4">
                Stok <span class="text-red-600">darah</span> tersedia: <span id="confirmStokValue" class="text-gray-900">0</span> kantong
            </h3>
            
            <p class="text-base text-gray-900 font-semibold mb-2">
                Apakah Anda yakin ingin memproses<br>permintaan ini?
            </p>
            
            <p class="text-sm text-gray-600 mb-8">
                Stok akan berkurang <span id="confirmKantongValue" class="font-semibold">0</span> kantong.
            </p>

            {{-- Buttons --}}
            <div class="grid grid-cols-2 gap-4">
                <button onclick="confirmProcess()" 
                        class="px-8 py-3 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                    <span class="text-green-600">Iya</span>
                </button>
                <button onclick="closeConfirmModal()" 
                        class="px-8 py-3 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                    <span class="text-red-600">Tidak</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ✅ TAMBAHAN: Modal Success --}}
<div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-12 relative">
        {{-- Close Button --}}
        <button onclick="reloadPage()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="text-center">
            {{-- Icon Success --}}
            <div class="w-32 h-32 bg-white border-2 border-gray-300 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-20 h-20 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            {{-- Text --}}
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Permintaan berhasil diproses!</h3>
            <p class="text-base font-semibold text-gray-900 mb-1">Status: <span class="text-gray-900">Terpenuhi</span></p>
            <p class="text-base text-gray-900">Stok darah telah dikurangi</p>
        </div>
    </div>
</div>

{{-- ✅ TAMBAHAN: Modal Selesai (untuk tombol Selesai) --}}
<div id="selesaiModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-12 relative">
        {{-- Close Button --}}
        <button onclick="reloadPage()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="text-center">
            {{-- Icon Success --}}
            <div class="w-32 h-32 bg-white border-2 border-gray-300 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-20 h-20 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            {{-- Text --}}
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Permintaan Donor Selesai</h3>
            <p class="text-2xl font-bold text-gray-900">Di Proses</p>
        </div>
    </div>
</div>

<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-8 relative">
        {{-- Close Button --}}
        <button onclick="closeRejectModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="text-center">
            {{-- Icon X Merah --}}
            <div class="w-20 h-20 bg-white border-2 border-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>

            {{-- Text --}}
            <h3 class="text-xl font-bold text-gray-900 mb-8">Permintaan Di Tolak!</h3>

            {{-- Button OK (tidak ada, auto close setelah 2 detik) --}}
        </div>
    </div>
</div>

<div id="stokKosongModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-8 relative">
        {{-- Close Button --}}
        <button onclick="closeStokKosongModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="text-center">
            {{-- Icon Warning --}}
            <div class="w-20 h-20 bg-white border-2 border-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>

            {{-- Text --}}
            <h3 class="text-xl font-bold text-gray-900 mb-2">Stok Darah Tidak Mencukupi!</h3>
            <p class="text-sm text-gray-600 mb-8">Permintaan dikirim ke pendonor.</p>
        </div>
    </div>
</div>

{{-- ✅ UPDATE: Modal Failed --}}
<div id="failedModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-12 relative">
        {{-- Close Button --}}
        <button onclick="closeFailedModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="text-center">
            {{-- Icon X Merah --}}
            <div class="w-32 h-32 bg-white border-2 border-gray-300 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-20 h-20 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>

            {{-- Text --}}
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Pendonor gagal</h3>
            <p class="text-2xl font-bold text-gray-900">mendonorkan darahnya!</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-submit ketika Enter di search box
document.querySelector('input[name="search"]')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        this.form.submit();
    }
});

function showDetail(id) {
    // Show modal
    document.getElementById('detailModal').classList.remove('hidden');
    
    // Fetch detail data
    fetch(`/managemen-permintaan-darurat/${id}/detail`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderDetail(data.data);
            } else {
                alert('Gagal memuat data');
                closeModal();
            }
        })
        .catch(error => {
            console.error(error);
            alert('Terjadi kesalahan');
            closeModal();
        });
}

function renderDetail(data) {
    const statusColors = {
        'Requesting': 'bg-purple-100 text-purple-700',
        'Responded': 'bg-indigo-100 text-indigo-700',
        'Pending': 'bg-blue-100 text-blue-700',
        'Approved': 'bg-yellow-100 text-yellow-700',
        'Completed': 'bg-green-100 text-green-700',
        'Rejected': 'bg-gray-100 text-gray-700',
        'Failed': 'bg-red-100 text-red-700'
    };

    const urgensiColors = {
        'Sangat Mendesak': 'text-red-600',
        'Mendesak': 'text-yellow-600',
        'Normal': 'text-green-600'
    };

    // ✅ Data Pendonor yang Merespons (jika ada)
    let pendonorSection = '';
    if (data.nama_pendonor_respond) {
        pendonorSection = `
            <div class="mb-4 p-3 bg-indigo-50 border border-indigo-200 rounded-lg">
                <h4 class="text-xs font-bold text-indigo-900 mb-2 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Pendonor yang Merespons
                </h4>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <p class="text-xs text-indigo-600 mb-0.5">Nama Pendonor</p>
                        <p class="text-xs font-semibold text-gray-900">${data.nama_pendonor_respond}</p>
                    </div>
                    <div>
                        <p class="text-xs text-indigo-600 mb-0.5">Golongan Darah</p>
                        <p class="text-xs font-bold text-red-600">${data.gol_darah_pendonor || '-'}</p>
                    </div>
                    <div>
                        <p class="text-xs text-indigo-600 mb-0.5">Tanggal Lahir</p>
                        <p class="text-xs text-gray-900">${data.tgl_lahir_pendonor ? new Date(data.tgl_lahir_pendonor).toLocaleDateString('id-ID') : '-'}</p>
                    </div>
                    <div>
                        <p class="text-xs text-indigo-600 mb-0.5">No. Telepon</p>
                        <p class="text-xs font-semibold text-blue-600">${data.no_telp_pendonor || '-'}</p>
                    </div>
                </div>
            </div>
        `;
    }

    const html = `
        <!-- Top Info - 3 kolom grid -->
        <div class="grid grid-cols-3 gap-3 pb-4 mb-4 border-b border-gray-200">
            <div>
                <p class="text-xs text-gray-500 mb-0.5">Nomor Tracking</p>
                <p class="text-xs font-bold text-red-600 break-all">${data.nomor_pelacakan}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-0.5">Tanggal</p>
                <p class="text-xs text-gray-900">${new Date(data.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: '2-digit' })}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 mb-0.5">Status</p>
                <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded ${statusColors[data.status_permintaan]}">
                    ${data.status_permintaan === 'Pending' ? 'Baru' : data.status_permintaan}
                </span>
            </div>
        </div>

        ${pendonorSection}

        <!-- Data Pasien -->
        <div class="mb-4">
            <h4 class="text-sm font-bold text-gray-900 mb-2">Data Pasien</h4>
            <div class="space-y-2">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Nama Pasien</p>
                        <p class="text-xs font-medium text-gray-900">${data.nama_pasien}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Golongan Darah</p>
                        <p class="text-xs font-bold text-red-600">${data.gol_darah}</p>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-0.5">Tempat Dirawat</p>
                    <p class="text-xs text-gray-900 flex items-start gap-1">
                        <svg class="w-3 h-3 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="flex-1">${data.tempat_rawat}</span>
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-0.5">Riwayat Penyakit</p>
                    <p class="text-xs text-gray-900">${data.riwayat || '-'}</p>
                </div>
            </div>
        </div>

        <!-- Kebutuhan Darah -->
        <div class="mb-4 pb-4 border-b border-gray-200">
            <h4 class="text-sm font-bold text-gray-900 mb-2">Kebutuhan Darah</h4>
            <div class="space-y-2">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Jenis Permintaan</p>
                        <p class="text-xs text-gray-900">${data.jenis_permintaan || 'Darah Lengkap (Whole Blood)'}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Jumlah Kantong</p>
                        <p class="text-xs font-semibold text-gray-900">${data.jumlah_kantong} kantong</p>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-0.5">Tingkat Urgensi</p>
                    <p class="text-xs font-bold ${urgensiColors[data.tingkat_urgensi]}">${data.tingkat_urgensi}</p>
                </div>
            </div>
        </div>

        <!-- Kontak Keluarga -->
        <div class="mb-4">
            <h4 class="text-sm font-bold text-gray-900 mb-2">Kontak Keluarga</h4>
            <div class="space-y-2">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Nama Kontak</p>
                        <p class="text-xs text-gray-900 flex items-center gap-1">
                            <svg class="w-3 h-3 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="truncate">${data.nama_kontak || '-'}</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">No. HP</p>
                        <p class="text-xs text-blue-600 font-medium flex items-center gap-1">
                            <svg class="w-3 h-3 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span class="truncate">${data.no_hp || '-'}</span>
                        </p>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-0.5">Hubungan</p>
                    <p class="text-xs text-gray-900">${data.hubungan || '-'}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="grid ${data.status_permintaan === 'Pending' || data.status_permintaan === 'Responded' ? 'grid-cols-2' : 'grid-cols-1'} gap-2 pt-2">
            ${data.status_permintaan === 'Pending' ? `
                <button onclick="prosesPermintaan(${data.permintaan_id}, '${data.gol_darah}', '${data.jenis_permintaan || 'Darah Lengkap (Whole Blood)'}', ${data.jumlah_kantong})" 
                        class="px-4 py-2.5 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors">
                    Proses Permintaan
                </button>
                <button onclick="tolakPermintaan(${data.permintaan_id})" 
                        class="px-4 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                    Tolak
                </button>
            ` : data.status_permintaan === 'Responded' ? `
                <button onclick="selesaikanPermintaan(${data.permintaan_id}, '${data.gol_darah}', '${data.jenis_permintaan || 'Darah Lengkap (Whole Blood)'}', ${data.jumlah_kantong})" 
                        class="px-4 py-2.5 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors">
                    Selesai
                </button>
                <button onclick="gagalkanPermintaan(${data.permintaan_id})" 
                        class="px-4 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                    Gagal
                </button>
            ` : ''}
        </div>
    `;

    document.getElementById('modalContent').innerHTML = html;
}

function closeModal() {
    document.getElementById('detailModal').classList.add('hidden');
    document.getElementById('modalContent').innerHTML = '';
}

let currentProcessData = null;

function prosesPermintaan(id, golDarah, jenisDarah, jumlahKantong) {
    // Cek stok terlebih dahulu
    fetch('/managemen-permintaan-darurat/cek-stok', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            golongan_darah: golDarah,
            jenis_darah: jenisDarah,
            jumlah_kantong: jumlahKantong
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.stok_cukup) {
            // ✅ Stok cukup → Tampilkan modal konfirmasi
            currentProcessData = { id, golDarah, jenisDarah, jumlahKantong };
            showConfirmModal(data.stok_tersedia, jumlahKantong);
        } else {
            // ✅ Stok TIDAK cukup → Update status jadi "Requesting" & tampilkan modal warning
            updateStatusToRequesting(id);
        }
    })
    .catch(error => {
        console.error(error);
        alert('Terjadi kesalahan saat mengecek stok');
    });
}

// ✅ TAMBAH FUNCTION BARU
function updateStatusToRequesting(id) {
    console.log('🔄 Updating status to Requesting for ID:', id);
    
    fetch(`/managemen-permintaan-darurat/${id}/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            status_permintaan: 'Requesting'
        })
    })
    .then(response => {
        console.log('📡 Response status:', response.status);
        console.log('📡 Response headers:', response.headers.get('content-type'));
        
        // ✅ CEK apakah response adalah JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Server tidak mengembalikan JSON. Kemungkinan terjadi error 500.');
        }
        
        // ✅ Parse JSON
        return response.json().then(data => {
            if (!response.ok) {
                throw new Error(data.message || `HTTP ${response.status}`);
            }
            return data;
        });
    })
    .then(data => {
        console.log('✅ Success:', data);
        
        if (data.success) {
            closeModal();
            showStokKosongModal();
        } else {
            alert('Error: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('❌ Error:', error);
        alert('Terjadi kesalahan saat mengupdate status:\n' + error.message + '\n\nCek console browser (F12) untuk detail.');
    });
}

function showStokKosongModal() {
    document.getElementById('stokKosongModal').classList.remove('hidden');
    
    // Auto close setelah 2 detik dan reload
    setTimeout(() => {
        closeStokKosongModal();
        window.location.reload();
    }, 2000);
}

function closeStokKosongModal() {
    document.getElementById('stokKosongModal').classList.add('hidden');
}

// Close modal stok kosong when clicking outside
document.getElementById('stokKosongModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeStokKosongModal();
        window.location.reload();
    }
});

// ✅ TAMBAH FUNCTION BARU
function showConfirmModal(stokTersedia, jumlahKantong) {
    document.getElementById('confirmStokValue').textContent = stokTersedia;
    document.getElementById('confirmKantongValue').textContent = jumlahKantong;
    document.getElementById('confirmModal').classList.remove('hidden');
}

function closeConfirmModal() {
    document.getElementById('confirmModal').classList.add('hidden');
    currentProcessData = null;
}

function confirmProcess() {
    if (!currentProcessData) return;
    
    const { id, golDarah, jenisDarah, jumlahKantong } = currentProcessData;
    
    // Proses permintaan
    processRequest(id, golDarah, jenisDarah, jumlahKantong);
    
    // Tutup modal konfirmasi
    closeConfirmModal();
}

function processRequest(id, golDarah, jenisDarah, jumlahKantong) {
    fetch(`/managemen-permintaan-darurat/${id}/proses`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            golongan_darah: golDarah,
            jenis_darah: jenisDarah,
            jumlah_kantong: jumlahKantong
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // ✅ TAMPILKAN MODAL SUCCESS (bukan alert)
            closeModal(); // Tutup modal detail
            showSuccessModal();
        } else {
            alert(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error(error);
        alert('Terjadi kesalahan');
    });
}

function selesaikanPermintaan(id, golDarah, jenisDarah, jumlahKantong) {
    // ✅ HAPUS confirm dialog
    // Update status menjadi Completed (tanpa kurangi stok karena pendonor sudah datang)
    fetch(`/managemen-permintaan-darurat/${id}/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            status_permintaan: 'Completed'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal();
            showSelesaiModal();
        } else {
            alert(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error(error);
        alert('Terjadi kesalahan saat menyelesaikan permintaan');
    });
}

// ✅ TAMBAH FUNCTION BARU
function showSuccessModal() {
    document.getElementById('successModal').classList.remove('hidden');
}

function showSelesaiModal() {
    document.getElementById('selesaiModal').classList.remove('hidden');
    
    // Auto close setelah 2 detik dan reload
    setTimeout(() => {
        reloadPage();
    }, 2000);
}

// Close modal selesai when clicking outside
document.getElementById('selesaiModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        reloadPage();
    }
});

function reloadPage() {
    window.location.reload();
}

// Close modal when clicking outside
document.getElementById('detailModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

document.getElementById('confirmModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeConfirmModal();
    }
});

document.getElementById('successModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        reloadPage();
    }
});

function tolakPermintaan(id) {
    // Update status menjadi Rejected
    fetch(`/managemen-permintaan-darurat/${id}/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            status_permintaan: 'Rejected'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Tutup modal detail
            closeModal();
            // Tampilkan modal reject
            showRejectModal();
        } else {
            alert(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error(error);
        alert('Terjadi kesalahan saat menolak permintaan');
    });
}

function showRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
    
    // Auto close setelah 2 detik dan reload
    setTimeout(() => {
        closeRejectModal();
        window.location.reload();
    }, 2000);
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

// Close modal reject when clicking outside
document.getElementById('rejectModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
        window.location.reload();
    }
});

function gagalkanPermintaan(id) {
    // ✅ HAPUS confirm dialog
    // Update status menjadi Failed
    fetch(`/managemen-permintaan-darurat/${id}/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            status_permintaan: 'Failed'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal();
            showFailedModal();
        } else {
            alert(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error(error);
        alert('Terjadi kesalahan saat mengupdate status');
    });
}

function showFailedModal() {
    document.getElementById('failedModal').classList.remove('hidden');
    
    // Auto close setelah 2 detik dan reload
    setTimeout(() => {
        closeFailedModal();
        window.location.reload();
    }, 2000);
}

function closeFailedModal() {
    document.getElementById('failedModal').classList.add('hidden');
}

// Close modal failed when clicking outside
document.getElementById('failedModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeFailedModal();
        window.location.reload();
    }
});

</script>
@endpush
@endsection