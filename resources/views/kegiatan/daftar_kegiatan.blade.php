{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\kegiatan\index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8 sm:py-12 transition-colors">
    <div class="container mx-auto px-4 max-w-7xl">
        
        {{-- Header Section --}}
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-3 transition-colors">Kegiatan Donor Darah</h1>
            <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base lg:text-lg transition-colors">Temukan kegiatan donor darah terdekat dan daftar sekarang</p>
        </div>

        {{-- Search & Filter Bar --}}
        <div class="mb-6 sm:mb-10 flex flex-col md:flex-row gap-3 sm:gap-4">
            <div class="flex-1 md:flex-[2] relative">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 dark:text-gray-500 absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 pointer-events-none transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" 
                    id="searchKegiatan"
                    placeholder="Cari kegiatan atau lokasi..." 
                    class="w-full px-4 sm:px-5 py-2.5 sm:py-3.5 pl-10 sm:pl-12 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-transparent shadow-sm dark:shadow-gray-900/50 transition-colors text-sm sm:text-base">
            </div>
            <div class="flex-1 md:flex-[2]">
               <select id="filterLokasi" class="w-full px-4 sm:px-5 py-2.5 sm:py-3.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-transparent shadow-sm dark:shadow-gray-900/50 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 transition-colors text-sm sm:text-base">
                <option value="" class="text-gray-500 dark:text-gray-400 dark:bg-gray-800">Semua Lokasi</option>
                <option value="Makassar" class="text-gray-900 dark:text-gray-100 dark:bg-gray-800">Makassar</option>
                <option value="Jakarta" class="text-gray-900 dark:text-gray-100 dark:bg-gray-800">Jakarta</option>
                <option value="Surabaya" class="text-gray-900 dark:text-gray-100 dark:bg-gray-800">Surabaya</option>
                <option value="Bandung" class="text-gray-900 dark:text-gray-100 dark:bg-gray-800">Bandung</option>
                </select>
            </div>
        </div>

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8" id="kegiatanGrid">
            @forelse($kegiatan as $item)
            <div class="kegiatan-card bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-md dark:shadow-gray-900/50 overflow-hidden hover:shadow-2xl dark:hover:shadow-gray-900/70 transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 dark:border-gray-700">
                
                {{-- Card Image with Badge --}}
                <div class="relative h-40 sm:h-48 lg:h-52">
                    <img src="{{ asset('images/donor-illustration.jpg') }}" 
                         alt="{{ $item->nama_kegiatan }}" 
                         class="w-full h-full object-cover"
                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 400 300\'%3E%3Crect width=\'400\' height=\'300\' fill=\'%23991b1b\'/%3E%3Cg transform=\'translate(200,150)\'%3E%3Ccircle r=\'40\' fill=\'%23dc2626\'/%3E%3Cpath d=\'M-15,-25 Q-25,-35 -25,-45 Q-25,-55 -15,-55 Q-5,-55 0,-50 Q5,-55 15,-55 Q25,-55 25,-45 Q25,-35 15,-25 L0,-10 Z\' fill=\'white\'/%3E%3C/g%3E%3Ctext x=\'200\' y=\'200\' text-anchor=\'middle\' fill=\'white\' font-size=\'18\' font-family=\'Arial\' font-weight=\'bold\'%3EDonor Darah%3C/text%3E%3C/svg%3E';">
                    
                    {{-- Status Badge --}}
                    <span class="absolute top-3 sm:top-4 right-3 sm:right-4 px-2.5 sm:px-4 py-1 sm:py-1.5 text-[10px] sm:text-xs font-bold rounded-full shadow-lg
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
                <div class="p-4 sm:p-5 lg:p-6">
                    <h3 class="text-base sm:text-lg lg:text-xl font-bold text-gray-900 dark:text-white mb-3 sm:mb-4 line-clamp-2 min-h-[2.5rem] sm:min-h-[3rem] lg:min-h-[3.5rem] leading-tight transition-colors">
                        {{ $item->nama_kegiatan }}
                    </h3>
                    
                    {{-- Date & Time --}}
                    <div class="flex items-start text-xs sm:text-sm text-gray-700 dark:text-gray-300 mb-2.5 sm:mb-3 transition-colors">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 mt-0.5 flex-shrink-0 text-red-600 dark:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div class="flex flex-col">
                            <span class="font-semibold">{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                            <span class="text-gray-600 dark:text-gray-400 mt-0.5 transition-colors">{{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }} WITA</span>
                        </div>
                    </div>

                    {{-- Location --}}
                    <div class="flex items-start text-xs sm:text-sm text-gray-700 dark:text-gray-300 mb-4 sm:mb-5 transition-colors min-h-[2.5rem] sm:min-h-[3rem]">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 mt-0.5 flex-shrink-0 text-red-600 dark:text-red-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="line-clamp-2 font-medium leading-relaxed">{{ $item->lokasi }}</span>
                    </div>

                    {{-- Button --}}
                    <a href="{{ route('kegiatan.show', $item->kegiatan_id) }}" 
                       class="block w-full text-center bg-red-600 dark:bg-red-600 hover:bg-red-700 dark:hover:bg-red-700 text-white font-bold py-2.5 sm:py-3 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform active:scale-95 text-sm sm:text-base">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 sm:py-20">
                <svg class="w-20 h-20 sm:w-24 sm:h-24 lg:w-28 lg:h-28 mx-auto text-gray-300 dark:text-gray-600 mb-4 sm:mb-6 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p class="text-gray-500 dark:text-gray-400 text-base sm:text-lg lg:text-xl font-semibold mb-2 transition-colors">Tidak ada kegiatan donor tersedia</p>
                <p class="text-gray-400 dark:text-gray-500 text-sm sm:text-base transition-colors">Silakan coba lagi nanti atau hubungi kami untuk informasi lebih lanjut</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($kegiatan->hasPages())
        <div class="mt-8 sm:mt-12 flex justify-center">
            <nav class="flex items-center gap-1.5 sm:gap-2">
                {{-- Previous Button --}}
                @if ($kegiatan->onFirstPage())
                    <span class="px-2.5 sm:px-4 py-1.5 sm:py-2 text-gray-400 dark:text-gray-600 bg-gray-100 dark:bg-gray-800 rounded-lg cursor-not-allowed transition-colors">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </span>
                @else
                    <a href="{{ $kegiatan->previousPageUrl() }}" class="px-2.5 sm:px-4 py-1.5 sm:py-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($kegiatan->getUrlRange(1, $kegiatan->lastPage()) as $page => $url)
                    @if ($page == $kegiatan->currentPage())
                        <span class="px-2.5 sm:px-4 py-1.5 sm:py-2 text-white bg-red-600 dark:bg-red-600 rounded-lg font-semibold shadow-md text-sm sm:text-base">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="px-2.5 sm:px-4 py-1.5 sm:py-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm sm:text-base">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next Button --}}
                @if ($kegiatan->hasMorePages())
                    <a href="{{ $kegiatan->nextPageUrl() }}" class="px-2.5 sm:px-4 py-1.5 sm:py-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @else
                    <span class="px-2.5 sm:px-4 py-1.5 sm:py-2 text-gray-400 dark:text-gray-600 bg-gray-100 dark:bg-gray-800 rounded-lg cursor-not-allowed transition-colors">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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