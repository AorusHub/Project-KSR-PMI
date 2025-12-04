@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 max-w-7xl">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Verifikasi Kelayakan</h1>
            <p class="text-gray-600">Kelola semua verifikasi kelayakan donor darah dari masyarakat</p>
        </div>

        {{-- Stats Card --}}
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <p class="text-sm text-gray-600 mb-2">Total Permintaan Verifikasi</p>
            <p class="text-4xl font-bold text-gray-900">{{ $totalPermintaan ?? 3 }}</p>
        </div>

        {{-- Search & Filter --}}
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Search --}}
                <div class="relative">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" 
                           id="searchInput"
                           placeholder="Cari nama pasien atau golongan darah..." 
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>

                {{-- Filter --}}
                <select id="filterKelayakan" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent bg-white">
                    <option value="">Semua Jenis Darah</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Kegiatan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
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
                            <td class="px-6 py-4 text-sm text-gray-600">pendonor@gmail.com</td>
                            <td class="px-6 py-4 text-sm text-gray-900">Donor Darah Kampus UNHAS</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Layak</span>
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="openModal('modalVerifikasi1')" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                                    Lihat Detail
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
                            <td class="px-6 py-4 text-sm text-gray-600">pendonor@gmail.com</td>
                            <td class="px-6 py-4 text-sm text-gray-900">Donor Darah Kampus UNHAS</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">Menunggu</span>
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="openModal('modalVerifikasi2')" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                                    Lihat Detail
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
                            <td class="px-6 py-4 text-sm text-gray-600">pendonor@gmail.com</td>
                            <td class="px-6 py-4 text-sm text-gray-900">Donor Darah Kampus UNHAS</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Ditolak</span>
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="openModal('modalVerifikasi3')" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                                    Lihat Detail
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

{{-- Modal Verifikasi 1 (Layak) --}}
<div id="modalVerifikasi1" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        {{-- Header --}}
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900">Verifikasi Kelayakan Donor</h2>
            <button onclick="closeModal('modalVerifikasi1')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Content --}}
        <div class="p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Data Pasien</h3>
            
            <div class="space-y-3 mb-6">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Nama Pasien</span>
                    <span class="text-sm font-medium text-gray-900">Ahmad Hidayat</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Golongan Darah</span>
                    <span class="px-3 py-1 text-sm font-bold text-white bg-red-600 rounded-full">A+</span>
                </div>
                <div class="flex justify-between items-start">
                    <span class="text-sm text-gray-600">Jawaban</span>
                    <div class="text-right text-sm max-w-md">
                        <p class="mb-2">✅ Berusia antara 17-60 tahun</p>
                        <p class="mb-2">✅ Berat badan > 45 kg</p>
                        <p class="mb-2 text-green-600">✅ Sedang dalam kondisi <span class="font-semibold">sehat</span> dan tidak sedang demam, batuk, pilek, atau flu</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> sedang mengonsumsi obat-obatan tertentu saat ini</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> pernah menderita atau memiliki riwayat penyakit menular seperti hepatitis, HIV/AIDS, atau sifilis</p>
                        <p class="mb-2">✅ Dalam 6 bulan terakhir <span class="font-semibold text-red-600">tidak</span> pernah ditato, ditindik, atau menjalani akupunktur</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> sedang hamil, menyusui, atau baru melahirkan dalam 6 bulan terakhir</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> pernah menjalani operasi besar atau menerima transfusi darah dalam 1 tahun terakhir</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> bepergian ke daerah endemis malaria dalam 1 tahun terakhir</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> mengalami alergi berat atau reaksi serius terhadap obat, makanan, atau transfusi darah sebelumnya</p>
                    </div>
                </div>
            </div>

            {{-- Action Button --}}
            <button onclick="alert('Status: Layak')" class="w-full py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                Layak
            </button>
        </div>
    </div>
</div>

{{-- Modal Verifikasi 2 (Menunggu - dengan tombol Layak/Tolak) --}}
<div id="modalVerifikasi2" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        {{-- Header --}}
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900">Verifikasi Kelayakan Donor</h2>
            <button onclick="closeModal('modalVerifikasi2')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Content --}}
        <div class="p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Data Pasien</h3>
            
            <div class="space-y-3 mb-6">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Nama Pasien</span>
                    <span class="text-sm font-medium text-gray-900">Andi Baso</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Golongan Darah</span>
                    <span class="px-3 py-1 text-sm font-bold text-white bg-red-600 rounded-full">O+</span>
                </div>
                <div class="flex justify-between items-start">
                    <span class="text-sm text-gray-600">Jawaban</span>
                    <div class="text-right text-sm max-w-md">
                        <p class="mb-2">✅ Berusia antara 17-60 tahun</p>
                        <p class="mb-2">✅ Berat badan > 45 kg</p>
                        <p class="mb-2 text-green-600">✅ Sedang dalam kondisi <span class="font-semibold">sehat</span> dan tidak sedang demam, batuk, pilek, atau flu</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> sedang mengonsumsi obat-obatan tertentu saat ini</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> pernah menderita atau memiliki riwayat penyakit menular seperti hepatitis, HIV/AIDS, atau sifilis</p>
                        <p class="mb-2">✅ Dalam 6 bulan terakhir <span class="font-semibold text-red-600">tidak</span> pernah ditato, ditindik, atau menjalani akupunktur</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> sedang hamil, menyusui, atau baru melahirkan dalam 6 bulan terakhir</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> pernah menjalani operasi besar atau menerima transfusi darah dalam 1 tahun terakhir</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> bepergian ke daerah endemis malaria dalam 1 tahun terakhir</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> mengalami alergi berat atau reaksi serius terhadap obat, makanan, atau transfusi darah sebelumnya</p>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="grid grid-cols-2 gap-3">
                <button onclick="verifikasiLayak(2)" class="py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                    Layak
                </button>
                <button onclick="verifikasiTolak(2)" class="py-3 bg-white text-gray-700 font-semibold rounded-lg border-2 border-gray-300 hover:bg-gray-50 transition-colors">
                    Tolak
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Verifikasi 3 (Ditolak) --}}
<div id="modalVerifikasi3" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        {{-- Header --}}
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900">Verifikasi Kelayakan Donor</h2>
            <button onclick="closeModal('modalVerifikasi3')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Content --}}
        <div class="p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Data Pasien</h3>
            
            <div class="space-y-3 mb-6">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Nama Pasien</span>
                    <span class="text-sm font-medium text-gray-900">Fatimah Zahra</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Golongan Darah</span>
                    <span class="px-3 py-1 text-sm font-bold text-white bg-red-600 rounded-full">B+</span>
                </div>
                <div class="flex justify-between items-start">
                    <span class="text-sm text-gray-600">Jawaban</span>
                    <div class="text-right text-sm max-w-md">
                        <p class="mb-2">✅ Berusia antara 17-60 tahun</p>
                        <p class="mb-2">✅ Berat badan > 45 kg</p>
                        <p class="mb-2 text-green-600">✅ Sedang dalam kondisi <span class="font-semibold">sehat</span> dan tidak sedang demam, batuk, pilek, atau flu</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> sedang mengonsumsi obat-obatan tertentu saat ini</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> pernah menderita atau memiliki riwayat penyakit menular seperti hepatitis, HIV/AIDS, atau sifilis</p>
                        <p class="mb-2">✅ Dalam 6 bulan terakhir <span class="font-semibold text-red-600">tidak</span> pernah ditato, ditindik, atau menjalani akupunktur</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> sedang hamil, menyusui, atau baru melahirkan dalam 6 bulan terakhir</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> pernah menjalani operasi besar atau menerima transfusi darah dalam 1 tahun terakhir</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> bepergian ke daerah endemis malaria dalam 1 tahun terakhir</p>
                        <p class="mb-2 text-red-600">❌ <span class="font-semibold">Tidak</span> mengalami alergi berat atau reaksi serius terhadap obat, makanan, atau transfusi darah sebelumnya</p>
                    </div>
                </div>
            </div>

            {{-- Status Badge --}}
            <div class="bg-red-50 border-2 border-red-200 rounded-lg p-4 text-center">
                <p class="text-red-700 font-semibold">Status: Ditolak</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
    document.getElementById(modalId).classList.add('flex');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.getElementById(modalId).classList.remove('flex');
}

function verifikasiLayak(id) {
    if (confirm('Apakah Anda yakin pendonor ini LAYAK untuk mendonor?')) {
        // AJAX request ke backend
        alert('Verifikasi LAYAK berhasil!');
        closeModal('modalVerifikasi' + id);
        location.reload();
    }
}

function verifikasiTolak(id) {
    if (confirm('Apakah Anda yakin pendonor ini TIDAK LAYAK untuk mendonor?')) {
        // AJAX request ke backend
        alert('Verifikasi DITOLAK berhasil!');
        closeModal('modalVerifikasi' + id);
        location.reload();
    }
}

// Search & Filter functionality
document.getElementById('searchInput').addEventListener('input', function() {
    // Implement search logic
});

document.getElementById('filterKelayakan').addEventListener('change', function() {
    // Implement filter logic
});

// Close modal when clicking outside
document.querySelectorAll('[id^="modalVerifikasi"]').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal(this.id);
        }
    });
});
</script>
@endpush
@endsection