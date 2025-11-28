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
    <div class="relative top-20 mx-auto p-6 border w-full max-w-md shadow-lg rounded-2xl bg-white">
        {{-- Modal Header --}}
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-900">Buat Kegiatan Donor Baru</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <form action="{{ route('managemen.kegiatan.store') }}" method="POST" id="formKegiatan">
            @csrf
            
            {{-- Nama Kegiatan --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Nama Kegiatan <span class="text-red-600">*</span>
                </label>
                <input type="text" 
                       name="nama_kegiatan" 
                       placeholder="Contoh: Donor Darah Kampus UNHAS"
                       required
                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
            </div>

            {{-- Tanggal --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Tanggal <span class="text-red-600">*</span>
                </label>
                <input type="date" 
                       name="tanggal" 
                       required
                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
            </div>

            {{-- Waktu Mulai dan Waktu Selesai --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Waktu mulai <span class="text-red-600">*</span>
                    </label>
                    <input type="time" 
                           name="waktu_mulai" 
                           required
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Waktu selesai <span class="text-red-600">*</span>
                    </label>
                    <input type="time" 
                           name="waktu_selesai" 
                           required
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                </div>
            </div>

            {{-- Lokasi --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Lokasi <span class="text-red-600">*</span>
                </label>
                <input type="text" 
                       name="lokasi" 
                       placeholder="Alamat lengkap lokasi kegiatan"
                       required
                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
            </div>

            {{-- Deskripsi --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Deskripsi
                </label>
                <textarea name="deskripsi" 
                          rows="3" 
                          placeholder="Deskripsi kegiatan..."
                          class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm"></textarea>
            </div>

            {{-- Hidden fields --}}
            <input type="hidden" name="status" value="Planned">
            <input type="hidden" name="target_donor" value="0">

            {{-- Modal Footer --}}
            <div class="flex gap-3">
                <button type="button" 
                        onclick="closeModal()"
                        class="flex-1 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2.5 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                    Buat Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Kegiatan --}}
<div id="modalEditKegiatan" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-6 border w-full max-w-md shadow-lg rounded-2xl bg-white">
        {{-- Modal Header --}}
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-900">Edit Kegiatan Donor</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Modal Body --}}
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
                       placeholder="Contoh: Donor Darah Kampus UNHAS"
                       required
                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
            </div>

            {{-- Tanggal --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Tanggal <span class="text-red-600">*</span>
                </label>
                <input type="date" 
                       name="tanggal" 
                       id="edit_tanggal"
                       required
                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
            </div>

            {{-- Waktu Mulai dan Waktu Selesai --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Waktu mulai <span class="text-red-600">*</span>
                    </label>
                    <input type="time" 
                           name="waktu_mulai" 
                           id="edit_waktu_mulai"
                           required
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Waktu selesai <span class="text-red-600">*</span>
                    </label>
                    <input type="time" 
                           name="waktu_selesai" 
                           id="edit_waktu_selesai"
                           required
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                </div>
            </div>

            {{-- Lokasi --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Lokasi <span class="text-red-600">*</span>
                </label>
                <input type="text" 
                       name="lokasi" 
                       id="edit_lokasi"
                       placeholder="Alamat lengkap lokasi kegiatan"
                       required
                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
            </div>

            {{-- Deskripsi --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Deskripsi
                </label>
                <textarea name="deskripsi" 
                          id="edit_deskripsi"
                          rows="3" 
                          placeholder="Deskripsi kegiatan..."
                          class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm"></textarea>
            </div>

            {{-- Hidden fields --}}
            <input type="hidden" name="target_donor" id="edit_target_donor" value="0">
            <input type="hidden" name="status" id="edit_status" value="">

            {{-- Modal Footer --}}
            <div class="flex gap-3">
                <button type="button" 
                        onclick="closeEditModal()"
                        class="flex-1 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2.5 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                    Update Kegiatan
                </button>
            </div>
        </form>
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

@push('scripts')
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
    function openEditModal(id) {
        const kegiatan = kegiatanData.find(k => k.kegiatan_id === id);
        
        if (!kegiatan) {
            alert('Data kegiatan tidak ditemukan');
            return;
        }

        // Populate form
        document.getElementById('edit_nama_kegiatan').value = kegiatan.nama_kegiatan;
        document.getElementById('edit_tanggal').value = kegiatan.tanggal;
        document.getElementById('edit_waktu_mulai').value = kegiatan.waktu_mulai;
        document.getElementById('edit_waktu_selesai').value = kegiatan.waktu_selesai;
        document.getElementById('edit_lokasi').value = kegiatan.lokasi;
        document.getElementById('edit_deskripsi').value = kegiatan.deskripsi || '';
        document.getElementById('edit_status').value = kegiatan.status;
        document.getElementById('edit_target_donor').value = kegiatan.target_donor || 0;

        // Set form action URL
        const form = document.getElementById('formEditKegiatan');
        form.action = `/managemen-kegiatan/${id}`;

        document.getElementById('modalEditKegiatan').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

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
</script>
@endpush
@endsection