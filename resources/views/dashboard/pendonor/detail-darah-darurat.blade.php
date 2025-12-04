@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 max-w-7xl">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Donor Darah Darurat</h1>
            <p class="text-gray-600">Permintaan donor darah darurat untuk membantu pasien membutuhkan.</p>
        </div>

        {{-- Stats Card --}}
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <p class="text-sm text-gray-600 mb-2">Total Permintaan</p>
            <p class="text-4xl font-bold text-gray-900">{{ $totalPermintaan ?? 3 }}</p>
        </div>

        {{-- Search --}}
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="relative">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" 
                       id="searchInput"
                       placeholder="Cari nama pasien atau golongan darah..." 
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Pengguna</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Gol. Darah</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Rumah Sakit</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tingkat Urgensi</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        {{-- Row 1 --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-900">1</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Ahmad Hidayat</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-sm font-bold text-white bg-red-600 rounded-full">A+</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">1 Kantong</td>
                            <td class="px-6 py-4 text-sm text-gray-900">RS Wahidin Sudirohusodo</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Mendesak</span>
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="openConfirmModal(1)" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                                    Donor Sekarang
                                </button>
                            </td>
                        </tr>

                        {{-- Row 2 --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-900">2</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Andi Baso</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-sm font-bold text-white bg-red-600 rounded-full">O+</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">2 Kantong</td>
                            <td class="px-6 py-4 text-sm text-gray-900">RS Unhas</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Mendesak</span>
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="openConfirmModal(2)" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                                    Donor Sekarang
                                </button>
                            </td>
                        </tr>

                        {{-- Row 3 --}}
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-900">3</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Fatimah Zahra</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-sm font-bold text-white bg-red-600 rounded-full">B+</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">1 Kantong</td>
                            <td class="px-6 py-4 text-sm text-gray-900">RS Bhayangkara</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Mendesak</span>
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="openConfirmModal(3)" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                                    Donor Sekarang
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

{{-- Modal Konfirmasi --}}
<div id="modalConfirm" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-8 relative">
        <button onclick="closeModal('modalConfirm')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        <div class="text-center">
            {{-- Question Icon --}}
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 mb-3">Apakah Anda yakin ingin menangapi permintaan donor darah untuk pasien ini?</h3>
            
            {{-- Action Buttons --}}
            <div class="grid grid-cols-2 gap-3 mt-6">
                <button onclick="confirmDonor()" class="py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                    Ya, Saya bersedia
                </button>
                <button onclick="closeModal('modalConfirm')" class="py-3 bg-white text-gray-700 font-semibold rounded-lg border-2 border-gray-300 hover:bg-gray-50 transition-colors">
                    Tidak
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Success --}}
<div id="modalSuccess" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-8 relative">
        <button onclick="closeModalAndReload('modalSuccess')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        <div class="text-center">
            {{-- Success Icon --}}
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 mb-3">Terima kasih!</h3>
            <p class="text-gray-600 mb-6">Data Anda telah dikirim untuk ditindaklanjuti.</p>
            
            <button onclick="closeModalAndReload('modalSuccess')" class="w-full py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                OK
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentDonorId = null;

function openConfirmModal(donorId) {
    currentDonorId = donorId;
    document.getElementById('modalConfirm').classList.remove('hidden');
    document.getElementById('modalConfirm').classList.add('flex');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.getElementById(modalId).classList.remove('flex');
}

function confirmDonor() {
    // AJAX request ke backend
    closeModal('modalConfirm');
    
    // Simulasi success
    setTimeout(() => {
        document.getElementById('modalSuccess').classList.remove('hidden');
        document.getElementById('modalSuccess').classList.add('flex');
    }, 300);
    
    // Implementasi AJAX sebenarnya:
    /*
    fetch(`/donor-darurat/${currentDonorId}/respond`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            pendonor_id: {{ auth()->user()->pendonor->pendonor_id ?? 'null' }}
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal('modalConfirm');
            document.getElementById('modalSuccess').classList.remove('hidden');
            document.getElementById('modalSuccess').classList.add('flex');
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memproses permintaan');
    });
    */
}

function closeModalAndReload(modalId) {
    closeModal(modalId);
    location.reload();
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Close modal when clicking outside
document.querySelectorAll('[id^="modal"]').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal(this.id);
        }
    });
});
</script>
@endpush
@endsection