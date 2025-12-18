@extends('layouts.app')

@section('title', 'Permintaan Darah Darurat')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-4 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-6 sm:mb-8">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">Donor Darah Darurat</h1>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1">Permintaan donor darah darurat untuk membantu pasien membutuhkan.</p>
        </div>

        {{-- Stats & Search Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-4 sm:mb-6">
            
            {{-- Total Permintaan Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-2">Total Permintaan</p>
                <p class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">{{ $permintaanDarurat->total() }}</p>
            </div>

            {{-- Search & Filter Card --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100 dark:border-gray-700">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Cari Permintaan</h3>
                <form action="{{ route('pendonor.permintaan-darah') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Search Input --}}
                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Cari nama pasien atau golongan darah..."
                                   class="w-full pl-12 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                        </div>

                        {{-- Filter Tingkat Urgensi --}}
                        <select name="tingkat_urgensi" 
                                onchange="this.form.submit()"
                                class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Tingkat Urgensi</option>
                            <option value="Sangat Mendesak" {{ request('tingkat_urgensi') == 'Sangat Mendesak' ? 'selected' : '' }}>Sangat Mendesak</option>
                            <option value="Mendesak" {{ request('tingkat_urgensi') == 'Mendesak' ? 'selected' : '' }}>Mendesak</option>
                            <option value="Normal" {{ request('tingkat_urgensi') == 'Normal' ? 'selected' : '' }}>Normal</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            
            {{-- Mobile Cards (visible on small screens) --}}
            <div class="block md:hidden divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($permintaanDarurat as $index => $permintaan)
                <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">No. {{ $permintaanDarurat->firstItem() + $index }}</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white mb-2">{{ $permintaan->nama_pasien }}</p>
                            <div class="flex items-center gap-2 flex-wrap mb-2">
                                <span class="px-2 py-0.5 text-xs font-bold rounded-md
                                    @if(in_array($permintaan->gol_darah, ['A+', 'A-'])) bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300
                                    @elseif(in_array($permintaan->gol_darah, ['B+', 'B-'])) bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300
                                    @elseif(in_array($permintaan->gol_darah, ['O+', 'O-'])) bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300
                                    @else bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300
                                    @endif">
                                    {{ $permintaan->gol_darah }}
                                </span>
                                <span class="text-xs text-gray-600 dark:text-gray-400">{{ $permintaan->jumlah_kantong }} Kantong</span>
                                <span class="text-xs font-semibold
                                    @if($permintaan->responden >= $permintaan->jumlah_kantong) text-green-600 dark:text-green-500
                                    @elseif($permintaan->responden > 0) text-blue-600 dark:text-blue-500
                                    @else text-gray-500 dark:text-gray-400
                                    @endif">
                                    {{ $permintaan->responden }} Responden
                                </span>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ $permintaan->tempat_rawat }}</p>
                            <p class="text-xs font-medium
                                @if($permintaan->tingkat_urgensi == 'Sangat Mendesak') text-red-600 dark:text-red-500
                                @elseif($permintaan->tingkat_urgensi == 'Mendesak') text-yellow-600 dark:text-yellow-500
                                @else text-green-600 dark:text-green-500
                                @endif">
                                {{ $permintaan->tingkat_urgensi }}
                            </p>
                        </div>
                    </div>
                    
                    {{-- Action Button --}}
                    @php
                        $sudahRespond = DB::table('respon_pendonor')
                            ->where('permintaan_id', $permintaan->permintaan_id)
                            ->where('user_id', auth()->id())
                            ->exists();
                    @endphp

                    @if($sudahRespond)
                        <span class="block w-full text-center px-4 py-2 text-sm font-semibold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded-lg">
                            ✓ Sudah Direspons
                        </span>
                    @elseif($permintaan->responden >= $permintaan->jumlah_kantong)
                        <span class="block w-full text-center px-4 py-2 text-sm font-semibold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            Penuh
                        </span>
                    @else
                        <button onclick="showModal({{ $permintaan->permintaan_id }}, '{{ $permintaan->nama_pasien }}', '{{ $permintaan->gol_darah }}', {{ $permintaan->jumlah_kantong }})" 
                                class="block w-full px-4 py-2 text-sm font-semibold text-white bg-red-600 dark:bg-red-700 rounded-lg hover:bg-red-700 dark:hover:bg-red-800 transition-colors">
                            Donor Sekarang
                        </button>
                    @endif
                </div>
                @empty
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Tidak ada permintaan donor darurat saat ini</p>
                </div>
                @endforelse
            </div>

            {{-- Desktop Table (hidden on small screens) --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Nama Pengguna</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Gol. Darah</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Responden</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Rumah Sakit</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Tingkat Urgensi</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($permintaanDarurat as $index => $permintaan)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $permintaanDarurat->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                                {{ $permintaan->nama_pasien }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center justify-center px-3 py-1 text-sm font-bold rounded-md
                                    @if(in_array($permintaan->gol_darah, ['A+', 'A-'])) bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300
                                    @elseif(in_array($permintaan->gol_darah, ['B+', 'B-'])) bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300
                                    @elseif(in_array($permintaan->gol_darah, ['O+', 'O-'])) bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300
                                    @else bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300
                                    @endif">
                                    {{ $permintaan->gol_darah }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $permintaan->jumlah_kantong }} Kantong
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold
                                    @if($permintaan->responden >= $permintaan->jumlah_kantong) text-green-600 dark:text-green-500
                                    @elseif($permintaan->responden > 0) text-blue-600 dark:text-blue-500
                                    @else text-gray-500 dark:text-gray-400
                                    @endif">
                                    {{ $permintaan->responden }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                {{ Str::limit($permintaan->tempat_rawat, 30) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium
                                    @if($permintaan->tingkat_urgensi == 'Sangat Mendesak') text-red-600 dark:text-red-500
                                    @elseif($permintaan->tingkat_urgensi == 'Mendesak') text-yellow-600 dark:text-yellow-500
                                    @else text-green-600 dark:text-green-500
                                    @endif">
                                    {{ $permintaan->tingkat_urgensi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $sudahRespond = DB::table('respon_pendonor')
                                        ->where('permintaan_id', $permintaan->permintaan_id)
                                        ->where('user_id', auth()->id())
                                        ->exists();
                                @endphp

                                @if($sudahRespond)
                                    <span class="px-4 py-2 text-sm font-semibold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded-lg cursor-not-allowed">
                                        ✓ Sudah Direspons
                                    </span>
                                @elseif($permintaan->responden >= $permintaan->jumlah_kantong)
                                    <span class="px-4 py-2 text-sm font-semibold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 rounded-lg cursor-not-allowed">
                                        Penuh
                                    </span>
                                @else
                                    <button onclick="showModal({{ $permintaan->permintaan_id }}, '{{ $permintaan->nama_pasien }}', '{{ $permintaan->gol_darah }}', {{ $permintaan->jumlah_kantong }})" 
                                            class="px-5 py-2 text-sm font-semibold text-white bg-red-600 dark:bg-red-700 rounded-lg hover:bg-red-700 dark:hover:bg-red-800 transition-colors">
                                        Donor Sekarang
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400 font-medium">Tidak ada permintaan donor darurat saat ini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($permintaanDarurat->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $permintaanDarurat->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Donor --}}
<div id="modalDonor" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 sm:p-8 max-w-md w-full relative">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        <div class="text-center">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-3">Konfirmasi Donor Darah</h3>
            <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Pasien:</p>
                <p class="text-base font-bold text-gray-900 dark:text-white" id="modalNamaPasien">-</p>
                <div class="flex items-center justify-center gap-4 mt-3">
                    <div>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Golongan Darah</p>
                        <p class="text-lg font-bold text-red-600 dark:text-red-500" id="modalGolDarah">-</p>
                    </div>
                    <div class="w-px h-8 bg-gray-300 dark:bg-gray-600"></div>
                    <div>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Jumlah</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white"><span id="modalJumlah">-</span> Kantong</p>
                    </div>
                </div>
            </div>
            
            {{-- Form Input Data Pendonor --}}
            <form id="formDonor" method="POST" class="space-y-4 mb-6 text-left">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama_pendonor" required
                           value="{{ auth()->user()->nama ?? '' }}"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                           placeholder="Masukkan nama lengkap">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Lahir</label>
                    @php
                        $tglLahir = auth()->user()->pendonor->tanggal_lahir ?? '';
                    @endphp
                    
                    <input type="text" 
                        id="tgl_lahir_display"
                        value="{{ $tglLahir ? \Carbon\Carbon::parse($tglLahir)->format('d/m/Y') : '' }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300"
                        placeholder="DD/MM/YYYY" readonly>
                    
                    <input type="hidden" name="tgl_lahir" value="{{ $tglLahir }}">
                    
                    @if(empty($tglLahir))
                        <p class="text-xs text-red-500 dark:text-red-400 mt-1">⚠️ Data tanggal lahir tidak ditemukan</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Golongan Darah</label>
                    <select name="gol_darah" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">Pilih Golongan Darah</option>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $gol)
                            <option value="{{ $gol }}" {{ (auth()->user()->pendonor->golongan_darah ?? '') == $gol ? 'selected' : '' }}>
                                {{ $gol }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">No. Telepon</label>
                    <input type="tel" 
                        name="no_telp"
                        value="{{ auth()->user()->pendonor->no_hp ?? '' }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300"
                        readonly>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="button" onclick="closeModal()" class="flex-1 px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-red-600 dark:bg-red-700 text-white font-semibold rounded-lg hover:bg-red-700 dark:hover:bg-red-800 transition-colors">
                        Ya, Saya Bersedia
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Success --}}
<div id="modalSuccess" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 sm:p-8 max-w-md w-full relative">
        <div class="text-center">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-green-600 dark:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-3">Terima Kasih!</h3>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-6 sm:mb-8">Respons Anda telah berhasil dikirim. Tim kami akan segera menghubungi Anda untuk koordinasi lebih lanjut.</p>
            
            <button onclick="location.reload()" class="w-full px-6 py-3 bg-green-600 dark:bg-green-700 text-white font-semibold rounded-lg hover:bg-green-700 dark:hover:bg-green-800 transition-colors">
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

document.getElementById('formDonor').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    console.log('=== Data yang akan dikirim ===');
    for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }
    
    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response:', data);
        
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