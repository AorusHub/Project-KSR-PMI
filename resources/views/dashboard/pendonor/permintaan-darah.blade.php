{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\pendonor\permintaan-darah.blade.php --}}
@extends('layouts.app')

@section('title', 'Permintaan Darah Darurat')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Permintaan Darah Darurat</h1>
            <p class="text-gray-600 mt-1">Permintaan donor darah darurat untuk membantu pasien membutuhkan.</p>
        </div>

        {{-- Stats & Search Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            
            {{-- Total Permintaan Card --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <p class="text-sm text-gray-600 mb-2">Total Permintaan</p>
                <p class="text-4xl font-bold text-red-600">{{ $permintaanDarurat->total() }}</p>
            </div>

            {{-- Search Card --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Cari Permintaan</h3>
                <form action="{{ route('pendonor.permintaan-darah') }}" method="GET">
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari nama pasien atau golongan darah..."
                               class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengguna</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gol. Darah</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rumah Sakit</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tingkat Urgensi</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($permintaanDarurat as $index => $permintaan)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $permintaanDarurat->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ $permintaan->nama_pasien }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-sm font-bold rounded-full
                                    @if($permintaan->golongan_darah == 'A+') bg-red-100 text-red-700
                                    @elseif($permintaan->golongan_darah == 'O+') bg-orange-100 text-orange-700
                                    @elseif($permintaan->golongan_darah == 'B+') bg-blue-100 text-blue-700
                                    @else bg-purple-100 text-purple-700
                                    @endif">
                                    {{ $permintaan->golongan_darah }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $permintaan->jumlah_kantong }} Kantong
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $permintaan->nama_rs }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($permintaan->tingkat_urgensi == 'Mendesak') bg-red-100 text-red-800
                                    @elseif($permintaan->tingkat_urgensi == 'Sedang') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800
                                    @endif">
                                    {{ $permintaan->tingkat_urgensi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $sudahRespond = $permintaan->responses()
                                        ->where('pendonor_id', auth()->user()->pendonor->pendonor_id)
                                        ->exists();
                                @endphp
                                
                                @if($sudahRespond)
                                    <span class="px-4 py-2 text-sm font-semibold text-gray-500 bg-gray-100 rounded-lg cursor-not-allowed">
                                        ✓ Sudah Merespons
                                    </span>
                                @else
                                    <button onclick="showModal({{ $permintaan->permintaan_id }}, '{{ $permintaan->nama_pasien }}', '{{ $permintaan->golongan_darah }}', {{ $permintaan->jumlah_kantong }})" 
                                            class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                                        Donor Sekarang
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-gray-500 font-medium">Tidak ada permintaan donor darurat saat ini</p>
                                <p class="text-sm text-gray-400 mt-1">Terima kasih atas kesediaan Anda untuk membantu</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($permintaanDarurat->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $permintaanDarurat->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Donor --}}
<div id="modalDonor" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 relative">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        <div class="text-center">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 mb-3">Konfirmasi Donor Darah</h3>
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-1">Pasien:</p>
                <p class="text-base font-bold text-gray-900" id="modalNamaPasien">-</p>
                <div class="flex items-center justify-center gap-4 mt-3">
                    <div>
                        <p class="text-xs text-gray-600">Golongan Darah</p>
                        <p class="text-lg font-bold text-red-600" id="modalGolDarah">-</p>
                    </div>
                    <div class="w-px h-8 bg-gray-300"></div>
                    <div>
                        <p class="text-xs text-gray-600">Jumlah</p>
                        <p class="text-lg font-bold text-gray-900"><span id="modalJumlah">-</span> Kantong</p>
                    </div>
                </div>
            </div>
            
            <p class="text-sm text-gray-600 mb-6">Apakah Anda bersedia mendonorkan darah untuk pasien ini?</p>
            
            <form id="formDonor" method="POST" class="flex gap-3">
                @csrf
                <button type="button" onclick="closeModal()" class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                    Ya, Saya Bersedia
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Modal Success --}}
<div id="modalSuccess" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 relative">
        <div class="text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 mb-3">Terima Kasih!</h3>
            <p class="text-gray-600 mb-8">Respons Anda telah berhasil dikirim. Tim kami akan segera menghubungi Anda untuk koordinasi lebih lanjut.</p>
            
            <button onclick="location.reload()" class="w-full px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                OK
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentPermintaanId = null;

function showModal(permintaanId, namaPasien, golDarah, jumlah) {
    currentPermintaanId = permintaanId;
    document.getElementById('modalNamaPasien').textContent = namaPasien;
    document.getElementById('modalGolDarah').textContent = golDarah;
    document.getElementById('modalJumlah').textContent = jumlah;
    document.getElementById('formDonor').action = `/pendonor/permintaan-darah/${permintaanId}/respond`;
    document.getElementById('modalDonor').classList.remove('hidden');
    document.getElementById('modalDonor').classList.add('flex');
}

function closeModal() {
    document.getElementById('modalDonor').classList.add('hidden');
    document.getElementById('modalDonor').classList.remove('flex');
}

// Handle form submit
document.getElementById('formDonor').addEventListener('submit', function(e) {
    e.preventDefault();
    
    fetch(this.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal();
            document.getElementById('modalSuccess').classList.remove('hidden');
            document.getElementById('modalSuccess').classList.add('flex');
        } else {
            alert(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim respons');
    });
});

// Close modal saat klik di luar
document.querySelectorAll('[id^="modal"]').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
            this.classList.remove('flex');
        }
    });
});
</script>
@endpush
@endsection