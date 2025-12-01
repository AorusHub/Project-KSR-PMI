{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\dev\managemen-permintaan-darurat.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Donor Darurat - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Manajemen Donor Darurat</h1>
            <p class="text-gray-600 mt-1">Kelola semua permintaan darurat dan daftar pendonor yang bersedia</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            {{-- Total Permintaan --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Total Permintaan</span>
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $totalPermintaan }}</p>
            </div>

            {{-- Belum Terpenuhi --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Belum Terpenuhi</span>
                    <div class="w-10 h-10 bg-red-50 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-red-600">{{ $belumTerpenuhi }}</p>
            </div>

            {{-- Diproses --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Diproses</span>
                    <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-blue-600">{{ $diproses }}</p>
            </div>

            {{-- Terpenuhi --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-600">Terpenuhi</span>
                    <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-green-600">{{ $terpenuhi }}</p>
            </div>
        </div>

        {{-- Search and Filter --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <form method="GET" action="{{ route('managemen.permintaan-darurat.index') }}" class="flex flex-col md:flex-row md:items-end gap-4">
                {{-- Search --}}
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Cari Permintaan</label>
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
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                </div>

                {{-- Filter Status --}}
                <div class="md:w-64">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Filter Status</label>
                    <select name="status" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Belum Terpenuhi</option>
                        <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Terkonfirmasi</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                {{-- Button --}}
                <button type="submit" class="px-6 py-3 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-colors whitespace-nowrap">
                    Terapkan Filter
                </button>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Nama Pasien</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Gol. Darah</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Jumlah</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Rumah Sakit</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Pendonor</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($permintaan as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ $item->nomor_pelacakan }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->nama_pasien }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-bold rounded-full 
                                    @if(in_array($item->gol_darah, ['A+', 'A-'])) bg-red-100 text-red-700
                                    @elseif(in_array($item->gol_darah, ['B+', 'B-'])) bg-blue-100 text-blue-700
                                    @elseif(in_array($item->gol_darah, ['O+', 'O-'])) bg-orange-100 text-orange-700
                                    @else bg-purple-100 text-purple-700
                                    @endif">
                                    {{ $item->gol_darah }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->jumlah_kantong }} kantong
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ Str::limit($item->tempat_rawat, 30) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->nama_kontak ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->status_permintaan == 'Pending')
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700">
                                        Belum Terpenuhi
                                    </span>
                                @elseif($item->status_permintaan == 'Approved')
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700">
                                        Menunggu Konfirmasi
                                    </span>
                                @elseif($item->status_permintaan == 'Completed')
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-700">
                                        Terkonfirmasi
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-gray-100 text-gray-700">
                                        {{ $item->status_permintaan }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    {{-- View Detail --}}
                                    <a href="{{ route('managemen.permintaan-darurat.show', $item->permintaan_id) }}" 
                                       class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                       title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    {{-- Proses (hanya jika Pending) --}}
                                    @if($item->status_permintaan == 'Pending')
                                    <button onclick="prosesPermintaan({{ $item->permintaan_id }})"
                                       class="px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                                        Proses
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada data permintaan donor
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

@push('scripts')
<script>
function prosesPermintaan(id) {
    if (confirm('Apakah Anda yakin ingin memproses permintaan ini?')) {
        fetch(`/managemen-permintaan-darurat/${id}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status_permintaan: 'Approved'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Permintaan berhasil diproses!');
                window.location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan');
            console.error(error);
        });
    }
}
</script>
@endpush
@endsection