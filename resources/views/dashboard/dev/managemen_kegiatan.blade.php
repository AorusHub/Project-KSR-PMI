{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\dev\managemen_kegiatan.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Kegiatan</h1>
            <p class="text-gray-600 mt-1">Kelola semua kegiatan donor darah</p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif

        {{-- Search & Create Button --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Kegiatan</label>
                    <div class="relative">
                        <input type="text" id="searchKegiatan" 
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                            placeholder="Cari berdasarkan nama atau lokasi...">
                        <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-end">
                    {{-- ✅ KEMBALI KE MODAL --}}
                    <button onclick="openCreateModal()" 
                        class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Kegiatan Baru
                    </button>
                </div>
            </div>
        </div>

        {{-- Table Kegiatan --}}
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kegiatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Partisipan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($kegiatan as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item->nama_kegiatan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ Str::limit($item->lokasi, 30) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->status == 'Planned')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Akan Datang
                                </span>
                                @elseif($item->status == 'Ongoing')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Berlangsung
                                </span>
                                @elseif($item->status == 'Completed')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Selesai
                                </span>
                                @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Dibatalkan
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->donasiDarah->count() ?? 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('admin.kegiatan.show', $item->kegiatan_id) }}" 
                                    class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                {{-- ✅ KEMBALI KE MODAL --}}
                                <button onclick='openEditModal(@json($item))' 
                                    class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.kegiatan.destroy', $item->kegiatan_id) }}" method="POST" class="inline" 
                                    onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-lg font-medium">Belum ada kegiatan donor</p>
                                <p class="text-sm mt-1">Mulai buat kegiatan donor baru sekarang</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($kegiatan->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $kegiatan->links() }}
            </div>
            @endif
        </div>

    </div>
</div>

{{-- ✅ MODAL CREATE --}}
<div id="createModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl max-w-xl w-full p-8 relative">
        <button onclick="closeCreateModal()" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <h3 class="text-2xl font-bold text-gray-900 mb-6">Buat Kegiatan Donor Baru</h3>

        <form action="{{ route('admin.kegiatan.store') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" name="nama_kegiatan" required
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all" 
                    placeholder="Contoh: Donor Darah Kampus UNHAS">
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-800 mb-2">Tanggal <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal" required
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Waktu mulai <span class="text-red-500">*</span></label>
                    <input type="time" name="waktu_mulai" required value="08:00"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Waktu Selesai <span class="text-red-500">*</span></label>
                    <input type="time" name="waktu_selesai" required value="14:00"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-800 mb-2">Lokasi <span class="text-red-500">*</span></label>
                <input type="text" name="lokasi" required
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all" 
                    placeholder="Alamat lengkap lokasi kegiatan">
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-800 mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all resize-none" 
                    placeholder="Deskripsi kegiatan..."></textarea>
            </div>

            <input type="hidden" name="target_donor" value="100">
            <input type="hidden" name="status" value="Planned">

            <div class="grid grid-cols-2 gap-4">
                <button type="button" onclick="closeCreateModal()" 
                    class="px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-all">
                    Batal
                </button>
                <button type="submit" 
                    class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-all shadow-md">
                    Buat Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ✅ MODAL EDIT --}}
<div id="editModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl max-w-xl w-full p-8 relative">
        <button onclick="closeEditModal()" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <h3 class="text-2xl font-bold text-gray-900 mb-6">Edit Kegiatan Donor</h3>

        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" id="edit_nama_kegiatan" name="nama_kegiatan" required
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all">
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-800 mb-2">Tanggal <span class="text-red-500">*</span></label>
                <input type="date" id="edit_tanggal" name="tanggal" required
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Waktu mulai <span class="text-red-500">*</span></label>
                    <input type="time" id="edit_waktu_mulai" name="waktu_mulai" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Waktu Selesai <span class="text-red-500">*</span></label>
                    <input type="time" id="edit_waktu_selesai" name="waktu_selesai" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-800 mb-2">Lokasi <span class="text-red-500">*</span></label>
                <input type="text" id="edit_lokasi" name="lokasi" required
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all">
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-800 mb-2">Deskripsi</label>
                <textarea id="edit_deskripsi" name="deskripsi" rows="3"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all resize-none" 
                    placeholder="Deskripsi kegiatan..."></textarea>
            </div>

            <input type="hidden" id="edit_target_donor" name="target_donor">
            <input type="hidden" id="edit_status" name="status">

            <div class="grid grid-cols-2 gap-4">
                <button type="button" onclick="closeEditModal()" 
                    class="px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-all">
                    Batal
                </button>
                <button type="submit" 
                    class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-all shadow-md">
                    Update Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Success --}}
<div id="successModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 max-w-sm mx-4 text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Operasi Berhasil</h3>
        <button onclick="closeSuccessModal()" 
            class="mt-4 px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
            OK
        </button>
    </div>
</div>

@push('scripts')
<script>
// Search
document.getElementById('searchKegiatan').addEventListener('keyup', function() {
    let searchText = this.value.toLowerCase();
    let rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchText) ? '' : 'none';
    });
});

// Create Modal
function openCreateModal() {
    document.getElementById('createModal').classList.remove('hidden');
}
function closeCreateModal() {
    document.getElementById('createModal').classList.add('hidden');
}

// Edit Modal - ✅ PERBAIKAN FORMAT TANGGAL
function openEditModal(kegiatan) {
    document.getElementById('formEdit').action = `/admin/kegiatan/${kegiatan.kegiatan_id}`;
    document.getElementById('edit_nama_kegiatan').value = kegiatan.nama_kegiatan;
    
    // ✅ Convert tanggal ke format Y-m-d (YYYY-MM-DD)
    let tanggal = kegiatan.tanggal;
    if (tanggal) {
        // Jika format dari database adalah "2025-11-15 00:00:00" atau "2025-11-15"
        let tanggalFormatted = tanggal.split(' ')[0]; // Ambil bagian tanggal saja
        document.getElementById('edit_tanggal').value = tanggalFormatted;
    }
    
    document.getElementById('edit_waktu_mulai').value = kegiatan.waktu_mulai.substring(0, 5);
    document.getElementById('edit_waktu_selesai').value = kegiatan.waktu_selesai.substring(0, 5);
    document.getElementById('edit_lokasi').value = kegiatan.lokasi;
    document.getElementById('edit_deskripsi').value = kegiatan.deskripsi || '';
    document.getElementById('edit_target_donor').value = kegiatan.target_donor || 100;
    document.getElementById('edit_status').value = kegiatan.status;
    document.getElementById('editModal').classList.remove('hidden');
}
function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Success Modal
function showSuccessModal() {
    document.getElementById('successModal').classList.remove('hidden');
    setTimeout(() => window.location.reload(), 2000);
}
function closeSuccessModal() {
    window.location.reload();
}

@if(session('success'))
    showSuccessModal();
@endif
</script>
@endpush
@endsection