{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\kegiatan\index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-7xl">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-3">Kegiatan Donor Darah</h1>
            <p class="text-gray-600 text-lg">Temukan kegiatan donor darah terdekat dan daftar sekarang</p>
        </div>

        {{-- Search & Filter Bar --}}
    <div class="mb-10 flex flex-col md:flex-row gap-4">
        <div class="flex-1 md:flex-[2] relative">
            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" 
                id="searchKegiatan"
                placeholder="Cari kegiatan atau lokasi..." 
                class="w-full px-5 py-3.5 pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-sm">
        </div>
        <div class="flex-1 md:flex-[2]">
           <select id="filterLokasi" class="w-full px-5 py-3.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent shadow-sm bg-white text-gray-500">
            <option value="" class="text-gray-500">Semua Lokasi</option>
            <option value="Makassar" class="text-gray-900">Makassar</option>
            <option value="Jakarta" class="text-gray-900">Jakarta</option>
            <option value="Surabaya" class="text-gray-900">Surabaya</option>
            <option value="Bandung" class="text-gray-900">Bandung</option>
            </select>
        </div>
    </div>

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="kegiatanGrid">
            @forelse($kegiatan as $item)
            <div class="kegiatan-card bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                
                {{-- Card Image with Badge --}}
                <div class="relative h-52">
                    <img src="{{ asset('images/donor-illustration.jpg') }}" 
                         alt="{{ $item->nama_kegiatan }}" 
                         class="w-full h-full object-cover"
                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 400 300\'%3E%3Crect width=\'400\' height=\'300\' fill=\'%23991b1b\'/%3E%3Cg transform=\'translate(200,150)\'%3E%3Ccircle r=\'40\' fill=\'%23dc2626\'/%3E%3Cpath d=\'M-15,-25 Q-25,-35 -25,-45 Q-25,-55 -15,-55 Q-5,-55 0,-50 Q5,-55 15,-55 Q25,-55 25,-45 Q25,-35 15,-25 L0,-10 Z\' fill=\'white\'/%3E%3C/g%3E%3Ctext x=\'200\' y=\'200\' text-anchor=\'middle\' fill=\'white\' font-size=\'18\' font-family=\'Arial\' font-weight=\'bold\'%3EDonor Darah%3C/text%3E%3C/svg%3E';">
                    
                    {{-- Status Badge --}}
                    <span class="absolute top-4 right-4 px-4 py-1.5 text-xs font-bold rounded-full shadow-lg
                        @if($item->status === 'Planned') bg-blue-500 text-white
                        @elseif($item->status === 'Ongoing') bg-green-500 text-white
                        @elseif($item->status === 'Completed') bg-gray-500 text-white
                        @else bg-red-500 text-white
                        @endif">
                        @if($item->status === 'Planned') Akan Datang
                        @elseif($item->status === 'Ongoing') Berlangsung
                        @elseif($item->status === 'Completed') Selesai
                        @else Dibatalkan
                        @endif
                    </span>
                </div>

                {{-- Card Content --}}
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 line-clamp-2 min-h-[3.5rem] leading-tight">
                        {{ $item->nama_kegiatan }}
                    </h3>
                    
                    {{-- Date & Time --}}
                    <div class="flex items-start text-sm text-gray-700 mb-3">
                        <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div class="flex flex-col">
                            <span class="font-semibold">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                            <span class="text-gray-600 mt-0.5">{{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }} WITA</span>
                        </div>
                    </div>

                    {{-- Location --}}
                    <div class="flex items-start text-sm text-gray-700 mb-5">
                        <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="line-clamp-2 font-medium">{{ $item->lokasi }}</span>
                    </div>

                    {{-- Button --}}
                    <a href="{{ route('kegiatan.show', $item->kegiatan_id) }}" 
                       class="block w-full text-center bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20">
                <svg class="w-28 h-28 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p class="text-gray-500 text-xl font-semibold mb-2">Tidak ada kegiatan donor tersedia</p>
                <p class="text-gray-400">Silakan coba lagi nanti atau hubungi kami untuk informasi lebih lanjut</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
@if($kegiatan->hasPages())
<div class="mt-12 flex justify-center">
    <nav class="flex items-center gap-2">
        {{-- Previous Button --}}
        @if ($kegiatan->onFirstPage())
            <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </span>
        @else
            <a href="{{ $kegiatan->previousPageUrl() }}" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($kegiatan->getUrlRange(1, $kegiatan->lastPage()) as $page => $url)
            @if ($page == $kegiatan->currentPage())
                <span class="px-4 py-2 text-white bg-red-600 rounded-lg font-semibold shadow-md">
                    {{ $page }}
                </span>
            @else
                <a href="{{ $url }}" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        {{-- Next Button --}}
        @if ($kegiatan->hasMorePages())
            <a href="{{ $kegiatan->nextPageUrl() }}" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        @else
            <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </span>
        @endif
    </nav>
</div>
@endif
    </div>
</div>

@push('scripts')
<script>
// Search Functionality
document.getElementById('searchKegiatan')?.addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    filterKegiatan(searchText, document.getElementById('filterLokasi').value);
});

// Filter by Location
document.getElementById('filterLokasi')?.addEventListener('change', function() {
    const searchText = document.getElementById('searchKegiatan').value.toLowerCase();
    filterKegiatan(searchText, this.value);
});

function filterKegiatan(searchText, lokasi) {
    const cards = document.querySelectorAll('.kegiatan-card');
    
    cards.forEach(card => {
        const cardText = card.textContent.toLowerCase();
        const matchSearch = searchText === '' || cardText.includes(searchText);
        const matchLokasi = lokasi === '' || cardText.includes(lokasi.toLowerCase());
        
        if (matchSearch && matchLokasi) {
            card.parentElement.style.display = '';
        } else {
            card.parentElement.style.display = 'none';
        }
    });
}
</script>
@endpush
@endsection