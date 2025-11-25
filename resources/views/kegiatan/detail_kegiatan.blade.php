{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\kegiatan\detail_kegiatan.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    <div class="max-w-2xl mx-auto">
        
        {{-- Back Button --}}
        <div class="px-4 py-4">
            <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center text-gray-700 hover:text-gray-900 transition-colors">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="font-medium">Kembali</span>
            </a>
        </div>

        {{-- Hero Image with Badge --}}
        <div class="relative">
            <div class="h-64 bg-gradient-to-r from-pink-700 via-pink-800 to-pink-900 rounded-2xl mx-4 overflow-hidden">
                <img src="{{ asset('images/donor-illustration.png') }}" 
                     alt="Donor Darah Illustration" 
                     class="w-full h-full object-contain"
                     onerror="this.style.display='none'">
            </div>
            
            <span class="absolute top-4 right-8 px-4 py-1.5 text-xs font-bold rounded-full shadow-lg
                @if($kegiatan->status == 'Planned') bg-blue-500
                @elseif($kegiatan->status == 'Ongoing') bg-green-500
                @else bg-gray-500
                @endif text-white">
                @if($kegiatan->status == 'Planned') Akan Datang
                @elseif($kegiatan->status == 'Ongoing') Berlangsung
                @else Selesai
                @endif
            </span>
        </div>

        {{-- Content Section --}}
        <div class="px-4 py-6">
            
            {{-- Title --}}
            <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $kegiatan->nama_kegiatan }}</h1>
            <p class="text-sm text-gray-600 mb-6">
                @if($kegiatan->deskripsi)
                    {{ Str::limit($kegiatan->deskripsi, 100) }}
                @else
                    Kegiatan donor darah rutin di kampus Universitas Hasanuddin. Mari berbagi kehidupan bersama KSR PMI UNHAS!
                @endif
            </p>

            {{-- Two Column Layout --}}
            <div class="grid grid-cols-2 gap-6">
                
                {{-- Left Column --}}
                <div class="space-y-6">
                    
                    {{-- Tentang Kegiatan Ini --}}
                    <div>
                        <h3 class="text-base font-bold text-gray-900 mb-3">Tentang Kegiatan Ini</h3>
                        <p class="text-sm text-gray-700 leading-relaxed">
                            @if($kegiatan->deskripsi)
                                {{ $kegiatan->deskripsi }}
                            @else
                                Kegiatan donor darah ini merupakan bagian dari program rutin KSR PMI UNHAS untuk membantu memenuhi kebutuhan darah di wilayah Makassar dan sekitarnya. Setiap tetes darah yang Anda donorkan dapat menyelamatkan nyawa seseorang.
                            @endif
                        </p>
                    </div>

                    {{-- Persyaratan Donor --}}
                    <div>
                        <h3 class="text-base font-bold text-gray-900 mb-3">Persyaratan Donor</h3>
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li>Berusia 17-60 tahun</li>
                            <li>Berat badan minimal 45 kg</li>
                            <li>Dalam kondisi sehat</li>
                            <li>Tidak sedang hamil atau menyusui</li>
                            <li>Tidak memiliki penyakit menular</li>
                            <li>Jarak donor minimal 3 bulan dari donor terakhir</li>
                        </ul>
                    </div>

                    {{-- Yang Perlu Dibawa --}}
                    <div>
                        <h3 class="text-base font-bold text-gray-900 mb-3">Yang Perlu Dibawa</h3>
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li>KTP atau identitas resmi lainnya</li>
                            <li>Kartu donor (jika sudah pernah donor)</li>
                            <li>Kondisi fisik yang fit</li>
                        </ul>
                    </div>
                </div>

                {{-- Right Column - Event Details Card --}}
                <div>
                    <div class="bg-white border border-gray-200 rounded-xl p-5 space-y-5">
                        
                        {{-- Tanggal --}}
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 mb-0.5">Tanggal</p>
                                <p class="text-sm text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</p>
                            </div>
                        </div>

                        {{-- Waktu --}}
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 mb-0.5">Waktu</p>
                                <p class="text-sm text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($kegiatan->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($kegiatan->waktu_selesai)->format('H:i') }} WITA</p>
                            </div>
                        </div>

                        {{-- Lokasi --}}
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 mb-0.5">Lokasi</p>
                                <p class="text-sm text-gray-900 font-semibold">{{ $kegiatan->lokasi }}</p>
                            </div>
                        </div>

                        {{-- Peserta --}}
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 mb-0.5">Peserta</p>
                                <p class="text-sm text-gray-900 font-semibold">{{ $totalDonor ?? 0 }} terdaftar</p>
                            </div>
                        </div>

                       {{-- ✅ BUTTON BERDASARKAN ROLE --}}
                        @auth
                            @if(in_array(auth()->user()->role, ['admin', 'staf']))
                                {{-- ✅ BUTTON UNTUK ADMIN & STAF: Lihat Peserta --}}
                                <a href="{{ route('kegiatan.peserta', $kegiatan->kegiatan_id) }}" 
                                   class="block w-full py-3 rounded-lg font-bold text-white text-sm text-center transition-all duration-200 shadow-md bg-blue-600 hover:bg-blue-700">
                                    <div class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        Lihat Daftar Peserta
                                    </div>
                                </a>
                            @else
                                {{-- ✅ BUTTON UNTUK PENDONOR: Daftar Kegiatan --}}
                                @php
                                    $sudahDaftar = false;
                                    if(auth()->user()->pendonor) {
                                        $sudahDaftar = $kegiatan->donasiDarah()
                                            ->where('pendonor_id', auth()->user()->pendonor->pendonor_id)
                                            ->exists();
                                    }
                                @endphp

                                <button onclick="handleDaftar({{ $kegiatan->kegiatan_id }}, {{ $sudahDaftar ? 'true' : 'false' }})" 
                                        id="btnDaftar"
                                        class="w-full py-3 rounded-lg font-bold text-white text-sm transition-all duration-200 shadow-md
                                        {{ $sudahDaftar ? 'bg-gray-400 cursor-not-allowed' : 'bg-red-600 hover:bg-red-700' }}"
                                        {{ $sudahDaftar ? 'disabled' : '' }}>
                                    {{ $sudahDaftar ? '✓ Sudah Terdaftar' : 'Daftar Kegiatan' }}
                                </button>
                            @endif
                        @else
                            {{-- ✅ BUTTON UNTUK GUEST: Harus Login --}}
                            <button onclick="showModal('modalLoginRequired')" 
                                    class="w-full py-3 rounded-lg font-bold text-white text-sm transition-all duration-200 shadow-md bg-red-600 hover:bg-red-700">
                                Daftar Kegiatan
                            </button>
                        @endauth
                        {{-- Map Placeholder --}}
                        <div class="mt-4">
                            <div class="flex items-center justify-center h-40 bg-gray-100 rounded-lg border border-gray-200">
                                <div class="text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <p class="text-sm text-gray-700 font-medium">{{ $kegiatan->lokasi }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Tamalanrea, Makassar</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

{{-- Modal Login Required --}}
<div id="modalLoginRequired" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 relative">
        <button onclick="closeModal('modalLoginRequired')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        <div class="text-center">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 mb-3">Silakan masuk terlebih dahulu untuk mendaftar.</h3>
            <p class="text-gray-600 mb-8">Anda perlu login untuk dapat mendaftar kegiatan donor darah</p>
            
            <div class="flex gap-3">
                <button onclick="closeModal('modalLoginRequired')" class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <a href="{{ route('login') }}" class="flex-1 px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 text-center">
                    Login
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Modal Success --}}
<div id="modalSuccess" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 relative">
        <button onclick="closeModal('modalSuccess')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        <div class="text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 mb-3">Pendaftaran Berhasil!</h3>
            <p class="text-gray-600 mb-8">Anda telah terdaftar untuk kegiatan donor darah ini. Terima kasih atas partisipasi Anda!</p>
            
            <button onclick="closeModalAndReload('modalSuccess')" class="w-full px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700">
                OK
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function handleDaftar(kegiatanId, sudahDaftar) {
    if (sudahDaftar) return;

    @auth
        daftarKegiatan(kegiatanId);
    @else
        showModal('modalLoginRequired');
    @endauth
}

function daftarKegiatan(kegiatanId) {
    fetch(`/kegiatan-donor/${kegiatanId}/daftar`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showModal('modalSuccess');
        } else {
            alert(data.message || 'Gagal mendaftar');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

function showModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
    document.getElementById(modalId).classList.add('flex');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.getElementById(modalId).classList.remove('flex');
}

function closeModalAndReload(modalId) {
    closeModal(modalId);
    location.reload();
}
</script>
@endpush
@endsection