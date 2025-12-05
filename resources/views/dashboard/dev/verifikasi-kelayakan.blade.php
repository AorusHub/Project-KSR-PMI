{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\staf\verifikasi-kelayakan\index.blade.php --}}
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
            <p class="text-4xl font-bold text-gray-900">{{ $verifikasi->total() }}</p>
        </div>

        {{-- Search & Filter --}}
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <form action="{{ route('staf.verifikasi-kelayakan.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Search --}}
                    <div class="relative">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" 
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari nama pasien atau golongan darah..." 
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    </div>

                    {{-- Filter --}}
                    <select name="filter_darah" onchange="this.form.submit()" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent bg-white">
                        <option value="">Semua Jenis Darah</option>
                        <option value="A+" {{ request('filter_darah') == 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ request('filter_darah') == 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ request('filter_darah') == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ request('filter_darah') == 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="AB+" {{ request('filter_darah') == 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ request('filter_darah') == 'AB-' ? 'selected' : '' }}>AB-</option>
                        <option value="O+" {{ request('filter_darah') == 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ request('filter_darah') == 'O-' ? 'selected' : '' }}>O-</option>
                    </select>
                </div>
            </form>
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal Pengajuan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($verifikasi as $index => $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $verifikasi->firstItem() + $index }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->pendonor->nama }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-sm font-bold text-white bg-red-600 rounded-full">{{ $item->pendonor->golongan_darah }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->pendonor->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                @if($item->status_kelayakan == 'Layak')
                                    <span class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Layak</span>
                                @elseif($item->status_kelayakan == 'Tidak Layak')
                                    <span class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Tidak Layak</span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="openModal('modalVerifikasi{{ $item->verifikasi_id }}')" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                                    Lihat Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                Tidak ada data verifikasi kelayakan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($verifikasi->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $verifikasi->links() }}
            </div>
            @endif
        </div>

    </div>
</div>

{{-- Modal untuk setiap verifikasi --}}
@foreach($verifikasi as $item)
<div id="modalVerifikasi{{ $item->verifikasi_id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        {{-- Header --}}
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-900">Verifikasi Kelayakan Donor</h2>
            <button onclick="closeModal('modalVerifikasi{{ $item->verifikasi_id }}')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Content --}}
        <div class="p-6">
            <h3 class="text-base font-semibold text-gray-700 mb-6">Data Pendonor</h3>
            
            <div class="grid grid-cols-2 gap-x-8 gap-y-4 mb-6">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Nama Pendonor</p>
                    <p class="text-base font-medium text-gray-900">{{ $item->pendonor->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Golongan Darah</p>
                    <span class="inline-block px-3 py-1 text-sm font-bold text-white bg-red-600 rounded">{{ $item->pendonor->golongan_darah }}</span>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Email</p>
                    <p class="text-base font-medium text-gray-900">{{ $item->pendonor->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">No. HP</p>
                    <p class="text-base font-medium text-gray-900">{{ $item->pendonor->no_hp }}</p>
                </div>
            </div>

            <hr class="my-6">

            <h3 class="text-base font-semibold text-gray-700 mb-4">Data Kesehatan</h3>
            <div class="grid grid-cols-2 gap-x-8 gap-y-3 mb-6">
                <div>
                    <p class="text-sm text-gray-500">Berat Badan</p>
                    <p class="text-base font-medium text-gray-900">{{ $item->berat_badan }} kg</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Hemoglobin</p>
                    <p class="text-base font-medium text-gray-900">{{ $item->hemoglobin }} g/dL</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tekanan Darah</p>
                    <p class="text-base font-medium text-gray-900">{{ $item->tekanan_darah_sistol }}/{{ $item->tekanan_darah_diastol }} mmHg</p>
                </div>
                @if($item->suhu_tubuh)
                <div>
                    <p class="text-sm text-gray-500">Suhu Tubuh</p>
                    <p class="text-base font-medium text-gray-900">{{ $item->suhu_tubuh }}°C</p>
                </div>
                @endif
            </div>

            <hr class="my-6">

            <h3 class="text-base font-semibold text-gray-700 mb-4">Riwayat Kesehatan</h3>
            <div class="space-y-2 text-sm text-gray-700 mb-6">
                <p>{{ $item->sedang_sakit ? '❌' : '✅' }} Tidak sedang sakit (demam, batuk, pilek, flu)</p>
                <p>{{ $item->sedang_hamil ? '❌' : '✅' }} Tidak sedang hamil</p>
                <p>{{ $item->sedang_menyusui ? '❌' : '✅' }} Tidak sedang menyusui</p>
                <p>{{ $item->sedang_menstruasi ? '❌' : '✅' }} Tidak sedang menstruasi</p>
                <p>{{ $item->riwayat_penyakit_menular ? '❌' : '✅' }} Tidak memiliki riwayat penyakit menular (hepatitis, HIV/AIDS, sifilis)</p>
                <p>{{ $item->konsumsi_obat ? '❌' : '✅' }} Tidak sedang mengonsumsi obat-obatan tertentu</p>
                <p>{{ $item->minum_alkohol_24jam ? '❌' : '✅' }} Tidak minum alkohol dalam 24 jam terakhir</p>
                <p>{{ $item->tato_tindik_6bulan ? '❌' : '✅' }} Tidak ditato/ditindik dalam 6 bulan terakhir</p>
                <p>{{ $item->operasi_1tahun ? '❌' : '✅' }} Tidak menjalani operasi besar dalam 1 tahun terakhir</p>
                <p>{{ $item->transfusi_1tahun ? '❌' : '✅' }} Tidak menerima transfusi darah dalam 1 tahun terakhir</p>
            </div>

            @if($item->keterangan_tambahan)
            <div class="mb-6">
                <p class="text-sm font-semibold text-gray-700 mb-2">Keterangan Tambahan:</p>
                <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded">{{ $item->keterangan_tambahan }}</p>
            </div>
            @endif

            @if($item->status_kelayakan == 'Layak' || $item->status_kelayakan == 'Tidak Layak')
                {{-- Sudah diverifikasi --}}
                <div class="bg-{{ $item->status_kelayakan == 'Layak' ? 'green' : 'red' }}-50 border-2 border-{{ $item->status_kelayakan == 'Layak' ? 'green' : 'red' }}-200 rounded-lg p-4">
                    <p class="text-{{ $item->status_kelayakan == 'Layak' ? 'green' : 'red' }}-700 text-sm font-semibold mb-2">
                        Status: {{ $item->status_kelayakan }}
                    </p>
                    @if($item->catatan_petugas)
                    <p class="text-sm text-gray-600">Catatan: {{ $item->catatan_petugas }}</p>
                    @endif
                    <p class="text-xs text-gray-500 mt-2">
                        Diverifikasi oleh: {{ $item->verifiedBy->name ?? 'System' }} pada {{ $item->verified_at->format('d M Y H:i') }}
                    </p>
                </div>
            @else
                {{-- Menunggu verifikasi - tampilkan tombol --}}
                <form id="formVerifikasi{{ $item->verifikasi_id }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Petugas (opsional)</label>
                        <textarea name="catatan" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" onclick="verifikasiLayak({{ $item->verifikasi_id }})" class="py-3 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors">
                            Layak
                        </button>
                        <button type="button" onclick="verifikasiTolak({{ $item->verifikasi_id }})" class="py-3 bg-white text-gray-700 text-sm font-semibold rounded-lg border-2 border-gray-300 hover:bg-gray-50 transition-colors">
                            Tidak Layak
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endforeach

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

function verifikasiLayak(verifikasiId) {
    const form = document.getElementById('formVerifikasi' + verifikasiId);
    const catatan = form.querySelector('[name="catatan"]').value;
    
    fetch(`/staf/verifikasi-kelayakan/${verifikasiId}/approve`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ catatan: catatan })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memproses verifikasi');
    });
}

function verifikasiTolak(verifikasiId) {
    const form = document.getElementById('formVerifikasi' + verifikasiId);
    const catatan = form.querySelector('[name="catatan"]').value;
    
    fetch(`/staf/verifikasi-kelayakan/${verifikasiId}/reject`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ catatan: catatan })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memproses verifikasi');
    });
}

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