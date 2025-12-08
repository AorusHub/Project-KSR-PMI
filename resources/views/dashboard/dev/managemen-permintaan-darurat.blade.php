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
    <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        {{-- Header --}}
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
            <h3 class="text-lg font-bold text-gray-900">Detail Permintaan Donor</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Content --}}
        <div id="modalContent" class="p-6">
            {{-- Content will be loaded here --}}
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
        'Rejected': 'bg-gray-100 text-gray-700'
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
            <div class="mb-6 p-4 bg-indigo-50 border border-indigo-200 rounded-lg">
                <h4 class="text-sm font-bold text-indigo-900 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Pendonor yang Merespons
                </h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-indigo-600 mb-1">Nama Pendonor</p>
                        <p class="text-sm font-semibold text-gray-900">${data.nama_pendonor_respond}</p>
                    </div>
                    <div>
                        <p class="text-xs text-indigo-600 mb-1">Tanggal Lahir</p>
                        <p class="text-sm text-gray-900">${data.tgl_lahir_pendonor ? new Date(data.tgl_lahir_pendonor).toLocaleDateString('id-ID') : '-'}</p>
                    </div>
                    <div>
                        <p class="text-xs text-indigo-600 mb-1">Golongan Darah</p>
                        <p class="text-sm font-bold text-red-600">${data.gol_darah_pendonor || '-'}</p>
                    </div>
                    <div>
                        <p class="text-xs text-indigo-600 mb-1">No. Telepon</p>
                        <p class="text-sm font-semibold text-blue-600">${data.no_telp_pendonor || '-'}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-xs text-indigo-600 mb-1">Waktu Respons</p>
                        <p class="text-sm text-gray-900">${data.tanggal_respond ? new Date(data.tanggal_respond).toLocaleString('id-ID') : '-'}</p>
                    </div>
                </div>
            </div>
        `;
    }

    const html = `
        <!-- Top Info -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div>
                <p class="text-xs text-gray-600 mb-1">Nomor Tracking</p>
                <p class="text-sm font-bold text-red-600">${data.nomor_pelacakan}</p>
            </div>
            <div>
                <p class="text-xs text-gray-600 mb-1">Tanggal</p>
                <p class="text-sm font-semibold text-gray-900">${new Date(data.created_at).toLocaleDateString('id-ID')}</p>
            </div>
            <div>
                <p class="text-xs text-gray-600 mb-1">Status</p>
                <span class="px-2 py-1 text-xs font-semibold rounded-md ${statusColors[data.status_permintaan]}">
                    ${data.status_permintaan}
                </span>
            </div>
        </div>

        ${pendonorSection}

        <!-- Data Pasien -->
        <div class="mb-6">
            <h4 class="text-sm font-bold text-gray-900 mb-3">Data Pasien</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Nama Pasien</p>
                    <p class="text-sm font-semibold text-gray-900">${data.nama_pasien}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">Golongan Darah</p>
                    <p class="text-sm font-bold text-red-600">${data.gol_darah}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-gray-600 mb-1">Tempat Dirawat</p>
                    <p class="text-sm text-gray-900 flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        ${data.tempat_rawat}
                    </p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-gray-600 mb-1">Riwayat Penyakit</p>
                    <p class="text-sm text-gray-900">${data.riwayat || '-'}</p>
                </div>
            </div>
        </div>

        <!-- Kebutuhan Darah -->
        <div class="mb-6">
            <h4 class="text-sm font-bold text-gray-900 mb-3">Kebutuhan Darah</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Jenis Permintaan</p>
                    <p class="text-sm font-semibold text-gray-900">${data.jenis_permintaan || 'Darah Lengkap (Whole Blood)'}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">Jumlah Kantong</p>
                    <p class="text-sm font-bold text-gray-900">${data.jumlah_kantong} kantong</p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-gray-600 mb-1">Tingkat Urgensi</p>
                    <p class="text-sm font-bold ${urgensiColors[data.tingkat_urgensi]}">${data.tingkat_urgensi}</p>
                </div>
            </div>
        </div>

        <!-- Kontak Keluarga -->
        <div class="mb-6">
            <h4 class="text-sm font-bold text-gray-900 mb-3">Kontak Keluarga</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Nama Kontak</p>
                    <p class="text-sm font-semibold text-gray-900 flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        ${data.nama_kontak || '-'}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">No. HP</p>
                    <p class="text-sm font-semibold text-blue-600 flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        ${data.no_hp || '-'}
                    </p>
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-gray-600 mb-1">Hubungan</p>
                    <p class="text-sm text-gray-900">${data.hubungan || '-'}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-3 pt-4 border-t border-gray-200">
            ${data.status_permintaan === 'Responded' || data.status_permintaan === 'Pending' ? `
                <button onclick="prosesPermintaan(${data.permintaan_id}, '${data.gol_darah}', '${data.jenis_permintaan || 'Darah Lengkap (Whole Blood)'}', ${data.jumlah_kantong})" 
                        class="flex-1 px-4 py-3 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors">
                    Proses Permintaan
                </button>
            ` : ''}
            <button onclick="closeModal()" 
                    class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                Tutup
            </button>
        </div>
    `;

    document.getElementById('modalContent').innerHTML = html;
}

function closeModal() {
    document.getElementById('detailModal').classList.add('hidden');
    document.getElementById('modalContent').innerHTML = '';
}

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
            // Konfirmasi proses
            if (confirm(`Stok darah tersedia: ${data.stok_tersedia} kantong\n\nApakah Anda yakin ingin memproses permintaan ini?\nStok akan berkurang ${jumlahKantong} kantong.`)) {
                // Proses permintaan dan kurangi stok
                processRequest(id, golDarah, jenisDarah, jumlahKantong);
            }
        } else {
            alert(`Stok darah tidak mencukupi!\n\nStok tersedia: ${data.stok_tersedia} kantong\nDibutuhkan: ${jumlahKantong} kantong\nKekurangan: ${jumlahKantong - data.stok_tersedia} kantong`);
        }
    })
    .catch(error => {
        console.error(error);
        alert('Terjadi kesalahan saat mengecek stok');
    });
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
            alert('Permintaan berhasil diproses!\nStatus: Completed\nStok darah telah dikurangi.');
            closeModal();
            window.location.reload();
        } else {
            alert(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error(error);
        alert('Terjadi kesalahan');
    });
}

// Close modal when clicking outside
document.getElementById('detailModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endpush
@endsection