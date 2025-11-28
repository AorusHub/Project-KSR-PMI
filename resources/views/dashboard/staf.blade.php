{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\staf.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Staf - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Dashboard Anggota PMI</h1>
            <p class="text-gray-600 mt-1">Kelola kegiatan donor darah dan permintaan donor</p>
        </div>

        {{-- Stats Cards Row 1 --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            {{-- Permintaan Baru --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-gray-600">Permintaan Baru</span>
                    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold text-red-600">{{ $permintaanBaru }}</p>
            </div>

            {{-- Kegiatan Aktif --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-gray-600">Kegiatan Aktif</span>
                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold text-gray-900">{{ $kegiatanAktif }}</p>
            </div>

            {{-- Partisipan Bulan Ini --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-gray-600">Partisipan Bulan Ini</span>
                    <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold text-gray-900">{{ $partisipanBulanIni }}</p>
            </div>

            {{-- Total Kegiatan --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-gray-600">Total Kegiatan</span>
                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold text-gray-900">{{ $totalKegiatan }}</p>
            </div>
        </div>

        {{-- Stats Cards Row 2 --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            {{-- Menunggu Verifikasi Kelayakan --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-gray-600">Menunggu Verifikasi Kelayakan</span>
                    <div class="w-12 h-12 bg-orange-50 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold text-gray-900">{{ $menungguVerifikasi }}</p>
            </div>

            {{-- History Verifikasi Kelayakan --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-sm text-gray-600">History Verifikasi Kelayakan</span>
                    <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-4xl font-bold text-gray-900">{{ $historyVerifikasi }}</p>
            </div>

            {{-- Permintaan Donor Darah - Vertical Stack --}}
            <div class="col-span-2 space-y-4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-bold text-gray-900">Permintaan Donor Darah</h4>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900 font-medium">Lihat</a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-bold text-red-600">Permintaan Darah Darurat</h4>
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-900 font-medium">Lihat</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- LEFT COLUMN --}}
            <div class="space-y-6">
                
                {{-- Buat Kegiatan Baru --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Buat Kegiatan Baru</h3>
                            <p class="text-sm text-gray-500">Tambahkan kegiatan donor darah baru</p>
                        </div>
                        <button onclick="openModal()" class="w-12 h-12 bg-red-600 hover:bg-red-700 rounded-xl flex items-center justify-center text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Cek Kelayakan Baru --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Cek Kelayakan Baru</h3>
                            <p class="text-sm text-gray-500">Tambahkan kelayakan donor darah baru</p>
                        </div>
                        <button class="w-12 h-12 bg-red-600 hover:bg-red-700 rounded-xl flex items-center justify-center text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Permintaan Donor Terbaru --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Permintaan Donor Terbaru</h3>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gol. Darah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($permintaanTerbaru as $permintaan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $permintaan->nama_pasien }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $permintaan->golongan_darah }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $permintaan->jumlah_kantong }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                            @if($permintaan->status == 'Baru') bg-blue-100 text-blue-800
                                            @elseif($permintaan->status == 'Diproses') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800
                                            @endif">
                                            {{ $permintaan->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN --}}
            <div class="space-y-6">
                
                {{-- Kegiatan yang Sedang Berjalan --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Kegiatan yang Sedang Berjalan</h3>
                        <a href="{{ route('managemen.kegiatan.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">Kelola</a>
                    </div>
                    
                    <div class="divide-y divide-gray-200">
                        @forelse($kegiatanBerjalan as $kegiatan)
                        <div class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <h4 class="text-base font-bold text-gray-900 mb-2">{{ $kegiatan->nama_kegiatan }}</h4>
                                    <p class="text-xs text-gray-500 mb-1">
                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d F Y') }} • 
                                        {{ \Carbon\Carbon::parse($kegiatan->waktu_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($kegiatan->waktu_selesai)->format('H:i') }} WITA
                                    </p>
                                    <p class="text-xs text-gray-600">{{ $kegiatan->lokasi }}</p>
                                </div>
                                <span class="px-3 py-1 text-xs font-bold rounded-full whitespace-nowrap ml-3
                                    @if($kegiatan->status == 'Planned') bg-blue-100 text-blue-700
                                    @elseif($kegiatan->status == 'Ongoing') bg-green-100 text-green-700
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    {{ $kegiatan->status == 'Planned' ? 'Akan Datang' : ($kegiatan->status == 'Ongoing' ? 'Berlangsung' : $kegiatan->status) }}
                                </span>
                            </div>
                            <div class="flex gap-3 mt-4">
                                <button class="px-6 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Detail</button>
                                <button class="px-6 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">Kelola Partisipan</button>
                            </div>
                        </div>
                        @empty
                        <div class="p-6 text-center text-gray-500">
                            <p>Tidak ada kegiatan yang sedang berjalan</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ✅ MODAL BUAT KEGIATAN BARU --}}
<div id="modalKegiatan" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-6 border w-full max-w-md shadow-lg rounded-2xl bg-white">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-900">Buat Kegiatan Donor Baru</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('managemen.kegiatan.store') }}" method="POST" id="formKegiatan">
            @csrf
            
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

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Tanggal <span class="text-red-600">*</span>
                </label>
                <input type="date" 
                       name="tanggal" 
                       required
                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
            </div>

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

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Deskripsi
                </label>
                <textarea name="deskripsi" 
                          rows="3" 
                          placeholder="Deskripsi kegiatan..."
                          class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm"></textarea>
            </div>

            <input type="hidden" name="status" value="Planned">
            <input type="hidden" name="target_donor" value="0">

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
                <h3 class="text-xl font-bold text-white mb-2">Menyimpan Data...</h3>
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
            <h3 class="text-xl font-bold text-gray-900 mb-2">Kegiatan Berhasil Dibuat!</h3>
            <p class="text-sm text-gray-600">Halaman akan dimuat ulang...</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openModal() {
        document.getElementById('modalKegiatan').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('modalKegiatan').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('formKegiatan').reset();
    }

    // Close modal when clicking outside
    document.getElementById('modalKegiatan').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
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
        }
    });

    // ✅ HANDLE FORM SUBMISSION WITH LOADING
    document.getElementById('formKegiatan').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // 1. Tutup modal form
        document.getElementById('modalKegiatan').classList.add('hidden');
        
        // 2. Tampilkan loading modal
        document.getElementById('loadingModal').classList.remove('hidden');
        
        // 3. Submit form
        this.submit();
    });

    // ✅ CHECK FOR SUCCESS MESSAGE FROM SERVER
    @if(session('success'))
        // Hide loading modal
        document.getElementById('loadingModal').classList.add('hidden');
        
        // Show success modal
        document.getElementById('successModal').classList.remove('hidden');
        
        // Auto reload after 2 seconds
        setTimeout(function() {
            window.location.reload();
        }, 2000);
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