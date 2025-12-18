@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 sm:py-8 transition-colors">
    <div class="container mx-auto px-4 max-w-7xl">
        
        {{-- Header --}}
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-1 sm:mb-2 transition-colors">Donor Darah Darurat</h1>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 transition-colors">Permintaan donor darah darurat untuk membantu pasien membutuhkan.</p>
        </div>

        {{-- Stats Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm dark:shadow-gray-900/50 p-4 sm:p-6 mb-4 sm:mb-6 border border-gray-100 dark:border-gray-700 transition-colors">
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-1 sm:mb-2 transition-colors">Total Permintaan</p>
            <p class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white transition-colors">{{ $totalPermintaan ?? 3 }}</p>
        </div>

        {{-- Search --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm dark:shadow-gray-900/50 p-4 sm:p-6 mb-4 sm:mb-6 border border-gray-100 dark:border-gray-700 transition-colors">
            <div class="relative">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 dark:text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" 
                       id="searchInput"
                       placeholder="Cari nama pasien atau golongan darah..." 
                       class="w-full pl-9 sm:pl-10 pr-3 sm:pr-4 py-2.5 sm:py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-transparent transition-colors text-sm sm:text-base">
            </div>
        </div>

        {{-- Table - Desktop View --}}
        <div class="hidden lg:block bg-white dark:bg-gray-800 rounded-lg shadow-sm dark:shadow-gray-900/50 overflow-hidden border border-gray-100 dark:border-gray-700 transition-colors">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 transition-colors">
                        <tr>
                            <th class="px-4 xl:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider transition-colors">No</th>
                            <th class="px-4 xl:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider transition-colors">Nama Pengguna</th>
                            <th class="px-4 xl:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider transition-colors">Gol. Darah</th>
                            <th class="px-4 xl:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider transition-colors">Jumlah</th>
                            <th class="px-4 xl:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider transition-colors">Rumah Sakit</th>
                            <th class="px-4 xl:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider transition-colors">Tingkat Urgensi</th>
                            <th class="px-4 xl:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider transition-colors">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 transition-colors">
                        {{-- Row 1 --}}
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-4 xl:px-6 py-3 sm:py-4 text-sm text-gray-900 dark:text-gray-100 transition-colors">1</td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4 text-sm font-medium text-gray-900 dark:text-white transition-colors">Ahmad Hidayat</td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4">
                                <span class="px-2.5 sm:px-3 py-1 text-xs sm:text-sm font-bold text-white bg-red-600 dark:bg-red-500 rounded-full">A+</span>
                            </td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4 text-sm text-gray-900 dark:text-gray-100 transition-colors">1 Kantong</td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4 text-sm text-gray-900 dark:text-gray-100 transition-colors">RS Wahidin Sudirohusodo</td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4">
                                <span class="px-2.5 sm:px-3 py-1 text-xs font-semibold text-red-700 dark:text-red-300 bg-red-100 dark:bg-red-900/30 rounded-full transition-colors">Mendesak</span>
                            </td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4">
                                <button onclick="openConfirmModal(1)" class="px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-medium text-white bg-red-600 dark:bg-red-600 rounded-lg hover:bg-red-700 dark:hover:bg-red-700 transition-colors transform active:scale-95">
                                    Donor Sekarang
                                </button>
                            </td>
                        </tr>

                        {{-- Row 2 --}}
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-4 xl:px-6 py-3 sm:py-4 text-sm text-gray-900 dark:text-gray-100 transition-colors">2</td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4 text-sm font-medium text-gray-900 dark:text-white transition-colors">Andi Baso</td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4">
                                <span class="px-2.5 sm:px-3 py-1 text-xs sm:text-sm font-bold text-white bg-red-600 dark:bg-red-500 rounded-full">O+</span>
                            </td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4 text-sm text-gray-900 dark:text-gray-100 transition-colors">2 Kantong</td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4 text-sm text-gray-900 dark:text-gray-100 transition-colors">RS Unhas</td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4">
                                <span class="px-2.5 sm:px-3 py-1 text-xs font-semibold text-red-700 dark:text-red-300 bg-red-100 dark:bg-red-900/30 rounded-full transition-colors">Mendesak</span>
                            </td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4">
                                <button onclick="openConfirmModal(2)" class="px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-medium text-white bg-red-600 dark:bg-red-600 rounded-lg hover:bg-red-700 dark:hover:bg-red-700 transition-colors transform active:scale-95">
                                    Donor Sekarang
                                </button>
                            </td>
                        </tr>

                        {{-- Row 3 --}}
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-4 xl:px-6 py-3 sm:py-4 text-sm text-gray-900 dark:text-gray-100 transition-colors">3</td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4 text-sm font-medium text-gray-900 dark:text-white transition-colors">Fatimah Zahra</td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4">
                                <span class="px-2.5 sm:px-3 py-1 text-xs sm:text-sm font-bold text-white bg-red-600 dark:bg-red-500 rounded-full">B+</span>
                            </td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4 text-sm text-gray-900 dark:text-gray-100 transition-colors">1 Kantong</td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4 text-sm text-gray-900 dark:text-gray-100 transition-colors">RS Bhayangkara</td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4">
                                <span class="px-2.5 sm:px-3 py-1 text-xs font-semibold text-red-700 dark:text-red-300 bg-red-100 dark:bg-red-900/30 rounded-full transition-colors">Mendesak</span>
                            </td>
                            <td class="px-4 xl:px-6 py-3 sm:py-4">
                                <button onclick="openConfirmModal(3)" class="px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-medium text-white bg-red-600 dark:bg-red-600 rounded-lg hover:bg-red-700 dark:hover:bg-red-700 transition-colors transform active:scale-95">
                                    Donor Sekarang
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Card View - Mobile & Tablet --}}
        <div class="lg:hidden space-y-4">
            {{-- Card 1 --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm dark:shadow-gray-900/50 p-4 border border-gray-100 dark:border-gray-700 transition-colors">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 transition-colors">#1</span>
                            <span class="px-2.5 py-0.5 text-xs font-bold text-white bg-red-600 dark:bg-red-500 rounded-full">A+</span>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1 transition-colors">Ahmad Hidayat</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 transition-colors">RS Wahidin Sudirohusodo</p>
                    </div>
                    <span class="px-2.5 py-1 text-xs font-semibold text-red-700 dark:text-red-300 bg-red-100 dark:bg-red-900/30 rounded-full transition-colors">Mendesak</span>
                </div>
                <div class="mb-3 text-sm text-gray-700 dark:text-gray-300 transition-colors">
                    <span class="font-medium">Kebutuhan:</span> 1 Kantong
                </div>
                <button onclick="openConfirmModal(1)" class="w-full py-2.5 text-sm font-medium text-white bg-red-600 dark:bg-red-600 rounded-lg hover:bg-red-700 dark:hover:bg-red-700 transition-colors transform active:scale-95">
                    Donor Sekarang
                </button>
            </div>

            {{-- Card 2 --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm dark:shadow-gray-900/50 p-4 border border-gray-100 dark:border-gray-700 transition-colors">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 transition-colors">#2</span>
                            <span class="px-2.5 py-0.5 text-xs font-bold text-white bg-red-600 dark:bg-red-500 rounded-full">O+</span>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1 transition-colors">Andi Baso</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 transition-colors">RS Unhas</p>
                    </div>
                    <span class="px-2.5 py-1 text-xs font-semibold text-red-700 dark:text-red-300 bg-red-100 dark:bg-red-900/30 rounded-full transition-colors">Mendesak</span>
                </div>
                <div class="mb-3 text-sm text-gray-700 dark:text-gray-300 transition-colors">
                    <span class="font-medium">Kebutuhan:</span> 2 Kantong
                </div>
                <button onclick="openConfirmModal(2)" class="w-full py-2.5 text-sm font-medium text-white bg-red-600 dark:bg-red-600 rounded-lg hover:bg-red-700 dark:hover:bg-red-700 transition-colors transform active:scale-95">
                    Donor Sekarang
                </button>
            </div>

            {{-- Card 3 --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm dark:shadow-gray-900/50 p-4 border border-gray-100 dark:border-gray-700 transition-colors">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 transition-colors">#3</span>
                            <span class="px-2.5 py-0.5 text-xs font-bold text-white bg-red-600 dark:bg-red-500 rounded-full">B+</span>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1 transition-colors">Fatimah Zahra</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 transition-colors">RS Bhayangkara</p>
                    </div>
                    <span class="px-2.5 py-1 text-xs font-semibold text-red-700 dark:text-red-300 bg-red-100 dark:bg-red-900/30 rounded-full transition-colors">Mendesak</span>
                </div>
                <div class="mb-3 text-sm text-gray-700 dark:text-gray-300 transition-colors">
                    <span class="font-medium">Kebutuhan:</span> 1 Kantong
                </div>
                <button onclick="openConfirmModal(3)" class="w-full py-2.5 text-sm font-medium text-white bg-red-600 dark:bg-red-600 rounded-lg hover:bg-red-700 dark:hover:bg-red-700 transition-colors transform active:scale-95">
                    Donor Sekarang
                </button>
            </div>
        </div>

    </div>
</div>

{{-- Modal Konfirmasi --}}
<div id="modalConfirm" class="fixed inset-0 bg-black bg-opacity-50 dark:bg-opacity-70 hidden items-center justify-center z-50 p-4 transition-colors">
    <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl max-w-md w-full p-6 sm:p-8 relative border border-gray-100 dark:border-gray-700 transition-colors">
        <button onclick="closeModal('modalConfirm')" class="absolute top-3 sm:top-4 right-3 sm:right-4 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        <div class="text-center">
            {{-- Question Icon --}}
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6 transition-colors">
                <svg class="w-8 h-8 sm:w-12 sm:h-12 text-gray-500 dark:text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-3 transition-colors">Apakah Anda yakin ingin menanggapi permintaan donor darah untuk pasien ini?</h3>
            
            {{-- Action Buttons --}}
            <div class="grid grid-cols-2 gap-2.5 sm:gap-3 mt-4 sm:mt-6">
                <button onclick="confirmDonor()" class="py-2.5 sm:py-3 bg-green-600 dark:bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 dark:hover:bg-green-700 transition-colors text-sm sm:text-base transform active:scale-95">
                    Ya, Saya bersedia
                </button>
                <button onclick="closeModal('modalConfirm')" class="py-2.5 sm:py-3 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors text-sm sm:text-base transform active:scale-95">
                    Tidak
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Success --}}
<div id="modalSuccess" class="fixed inset-0 bg-black bg-opacity-50 dark:bg-opacity-70 hidden items-center justify-center z-50 p-4 transition-colors">
    <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl max-w-md w-full p-6 sm:p-8 relative border border-gray-100 dark:border-gray-700 transition-colors">
        <button onclick="closeModalAndReload('modalSuccess')" class="absolute top-3 sm:top-4 right-3 sm:right-4 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        <div class="text-center">
            {{-- Success Icon --}}
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6 transition-colors">
                <svg class="w-8 h-8 sm:w-12 sm:h-12 text-green-600 dark:text-green-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-3 transition-colors">Terima kasih!</h3>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-4 sm:mb-6 transition-colors">Data Anda telah dikirim untuk ditindaklanjuti.</p>
            
            <button onclick="closeModalAndReload('modalSuccess')" class="w-full py-2.5 sm:py-3 bg-red-600 dark:bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 dark:hover:bg-red-700 transition-colors text-sm sm:text-base transform active:scale-95">
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
    
    // Table rows
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    // Card view
    const cards = document.querySelectorAll('.lg\\:hidden > div');
    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
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