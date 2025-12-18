{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\kegiatan\detail_kegiatan.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white dark:bg-gray-900 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Back Button --}}
        <div class="py-4 sm:py-6">
            @auth
                @if(in_array(auth()->user()->role, ['admin', 'staf']))
                    <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                @else
                    <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                @endif
            @else
                <a href="{{ route('kegiatan.index') }}" class="inline-flex items-center text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
            @endauth
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="font-medium">Kembali</span>
            </a>
        </div>

        {{-- Hero Image with Badge --}}
        <div class="relative mb-6 sm:mb-8">
            <div class="h-48 sm:h-56 md:h-64 lg:h-72 bg-gradient-to-r from-red-600 via-red-700 to-red-800 dark:from-red-700 dark:via-red-800 dark:to-red-900 rounded-2xl overflow-hidden shadow-xl">
                <img src="{{ asset('images/donor-illustration.png') }}" 
                     alt="Donor Darah Illustration" 
                     class="w-full h-full object-contain"
                     onerror="this.style.display='none'">
            </div>
            
            <span class="absolute top-3 right-3 sm:top-4 sm:right-4 px-3 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm font-bold rounded-full shadow-lg
                @if($kegiatan->status === 'Planned') bg-blue-500
                @elseif($kegiatan->status === 'Ongoing') bg-green-500
                @else bg-gray-500
                @endif text-white">
                @if($kegiatan->status === 'Planned') Akan Datang
                @elseif($kegiatan->status === 'Ongoing') Berlangsung
                @else Selesai
                @endif
            </span>
        </div>

        {{-- Content Section --}}
        <div class="pb-8">
            
            {{-- Title --}}
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-2 transition-colors">{{ $kegiatan->nama_kegiatan }}</h1>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-6 sm:mb-8 leading-relaxed transition-colors">
                @if($kegiatan->deskripsi)
                    {{ Str::limit($kegiatan->deskripsi, 150) }}
                @else
                    Kegiatan donor darah rutin di kampus Universitas Hasanuddin. Mari berbagi kehidupan bersama KSR PMI UNHAS!
                @endif
            </p>

            {{-- Two Column Layout - RESPONSIVE --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                
                {{-- Left Column - CONTENT (2 kolom di desktop) --}}
                <div class="lg:col-span-2 space-y-6 sm:space-y-8">
                    
                    {{-- Tentang Kegiatan Ini --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 sm:p-6 shadow-md border border-gray-200 dark:border-gray-700 transition-colors">
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-3 sm:mb-4 flex items-center transition-colors">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Tentang Kegiatan Ini
                        </h3>
                        <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300 leading-relaxed transition-colors">
                            @if($kegiatan->deskripsi)
                                {{ $kegiatan->deskripsi }}
                            @else
                                Kegiatan donor darah ini merupakan bagian dari program rutin KSR PMI UNHAS untuk membantu memenuhi kebutuhan darah di wilayah Makassar dan sekitarnya. Setiap tetes darah yang Anda donorkan dapat menyelamatkan nyawa seseorang.
                            @endif
                        </p>
                    </div>

                    {{-- Persyaratan Donor --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 sm:p-6 shadow-md border border-gray-200 dark:border-gray-700 transition-colors">
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-3 sm:mb-4 flex items-center transition-colors">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Persyaratan Donor
                        </h3>
                        <ul class="text-sm sm:text-base text-gray-700 dark:text-gray-300 space-y-2 transition-colors">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Berusia 17-60 tahun</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Berat badan minimal 45 kg</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Dalam kondisi sehat</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Tidak sedang hamil atau menyusui</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Tidak memiliki penyakit menular</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Jarak donor minimal 3 bulan dari donor terakhir</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Yang Perlu Dibawa --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-5 sm:p-6 shadow-md border border-gray-200 dark:border-gray-700 transition-colors">
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-3 sm:mb-4 flex items-center transition-colors">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Yang Perlu Dibawa
                        </h3>
                        <ul class="text-sm sm:text-base text-gray-700 dark:text-gray-300 space-y-2 transition-colors">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>KTP atau identitas resmi lainnya</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Kartu donor (jika sudah pernah donor)</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Kondisi fisik yang fit</span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Right Column - EVENT DETAILS (1 kolom di desktop, sticky) --}}
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-5 sm:p-6 space-y-5 shadow-md transition-colors lg:sticky lg:top-20">
                        
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 transition-colors">Detail Kegiatan</h3>

                        {{-- Tanggal --}}
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-0.5 transition-colors">Tanggal</p>
                                <p class="text-sm sm:text-base text-gray-900 dark:text-white font-semibold transition-colors">{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d F Y') }}</p>
                            </div>
                        </div>

                        {{-- Waktu --}}
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-0.5 transition-colors">Waktu</p>
                                <p class="text-sm sm:text-base text-gray-900 dark:text-white font-semibold transition-colors">{{ \Carbon\Carbon::parse($kegiatan->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($kegiatan->waktu_selesai)->format('H:i') }} WITA</p>
                            </div>
                        </div>

                        {{-- Lokasi --}}
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-0.5 transition-colors">Lokasi</p>
                                <p class="text-sm sm:text-base text-gray-900 dark:text-white font-semibold transition-colors">{{ $kegiatan->lokasi }}</p>
                                @if($kegiatan->rincian_lokasi)
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 transition-colors">{{ $kegiatan->rincian_lokasi }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Peserta --}}
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-0.5 transition-colors">Peserta</p>
                                <p class="text-sm sm:text-base text-gray-900 dark:text-white font-semibold transition-colors">{{ $totalDonor ?? 0 }} terdaftar</p>
                            </div>
                        </div>

                       {{-- ✅ BUTTON BERDASARKAN ROLE --}}
                        @auth
                            @if(in_array(auth()->user()->role, ['admin', 'staf']))
                                {{-- ✅ BUTTON UNTUK ADMIN & STAF --}}
                                <a href="{{ route('kegiatan.peserta', $kegiatan->kegiatan_id) }}" 
                                   class="block w-full py-3 rounded-lg font-bold text-white text-sm text-center transition-all duration-200 shadow-md bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800">
                                    <div class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        Lihat Daftar Peserta
                                    </div>
                                </a>
                            @else
                                {{-- ✅ BUTTON UNTUK PENDONOR --}}
                                @php
                                    $sudahDaftar = false;
                                    if(auth()->user()->pendonor) {
                                        $sudahDaftar = $kegiatan->donasiDarah()
                                            ->where('pendonor_id', auth()->user()->pendonor->pendonor_id)
                                            ->exists();
                                    }
                                @endphp

                                @if(auth()->user()->pendonor)
                                    <button onclick="handleDaftar({{ $kegiatan->kegiatan_id }}, {{ $sudahDaftar ? 'true' : 'false' }})" 
                                            id="btnDaftar"
                                            class="w-full py-3 rounded-lg font-bold text-white text-sm transition-all duration-200 shadow-md
                                            {{ $sudahDaftar ? 'bg-gray-400 dark:bg-gray-600 cursor-not-allowed' : 'bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800' }}"
                                            {{ $sudahDaftar ? 'disabled' : '' }}>
                                        {{ $sudahDaftar ? '✓ Sudah Terdaftar' : 'Daftar Kegiatan' }}
                                    </button>
                                @else
                                    <button onclick="showModal('modalProfilRequired')" 
                                            class="w-full py-3 rounded-lg font-bold text-white text-sm transition-all duration-200 shadow-md bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700">
                                        Lengkapi Profil Pendonor
                                    </button>
                                @endif
                            @endif
                        @else
                            {{-- ✅ BUTTON UNTUK GUEST --}}
                            <button onclick="showModal('modalLoginRequired')" 
                                    class="w-full py-3 rounded-lg font-bold text-white text-sm transition-all duration-200 shadow-md bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800">
                                Daftar Kegiatan
                            </button>
                        @endauth

                        {{-- ✅ MAP INTERACTIVE --}}
                        <div class="mt-5 border-t border-gray-200 dark:border-gray-700 pt-5">
                            @if($kegiatan->latitude && $kegiatan->longitude)
                                {{-- Map Container --}}
                                <div id="detailMap" class="h-48 sm:h-56 rounded-lg border-2 border-gray-300 dark:border-gray-600 overflow-hidden relative z-0"></div>
                                
                                {{-- Address Info --}}
                                <div class="mt-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600 transition-colors">
                                    <div class="flex items-start">
                                        <svg class="w-4 h-4 text-red-600 dark:text-red-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white transition-colors">{{ $kegiatan->lokasi }}</p>
                                            @if($kegiatan->rincian_lokasi)
                                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 transition-colors">{{ $kegiatan->rincian_lokasi }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    {{-- Button Google Maps --}}
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $kegiatan->latitude }},{{ $kegiatan->longitude }}" 
                                       target="_blank"
                                       class="mt-3 flex items-center justify-center w-full py-2 px-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                        Buka di Google Maps
                                    </a>
                                </div>
                            @else
                                {{-- Fallback --}}
                                <div class="flex items-center justify-center h-48 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 transition-colors">
                                    <div class="text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 font-medium transition-colors">{{ $kegiatan->lokasi }}</p>
                                        @if($kegiatan->rincian_lokasi)
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 transition-colors">{{ $kegiatan->rincian_lokasi }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

{{-- Modal Login Required --}}
<div id="modalLoginRequired" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 sm:p-8 max-w-md w-full relative shadow-2xl transition-colors">
        <button onclick="closeModal('modalLoginRequired')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        <div class="text-center">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-3 transition-colors">Silakan masuk terlebih dahulu</h3>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-6 sm:mb-8 transition-colors">Anda perlu login untuk dapat mendaftar kegiatan donor darah</p>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <button onclick="closeModal('modalLoginRequired')" class="flex-1 px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Batal
                </button>
                <a href="{{ route('login') }}" class="flex-1 px-6 py-3 bg-red-600 dark:bg-red-700 text-white font-semibold rounded-lg hover:bg-red-700 dark:hover:bg-red-800 text-center transition-colors">
                    Login
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Modal Success --}}
<div id="modalSuccess" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 sm:p-8 max-w-md w-full relative shadow-2xl transition-colors">
        <button onclick="closeModal('modalSuccess')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        <div class="text-center">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-3 transition-colors">Pendaftaran Berhasil!</h3>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-6 sm:mb-8 transition-colors">Anda telah terdaftar untuk kegiatan donor darah ini. Terima kasih atas partisipasi Anda!</p>
            
            <button onclick="closeModalAndReload('modalSuccess')" class="w-full px-6 py-3 bg-green-600 dark:bg-green-700 text-white font-semibold rounded-lg hover:bg-green-700 dark:hover:bg-green-800 transition-colors">
                OK
            </button>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* Map container - FIX Z-INDEX */
    #detailMap {
        position: relative;
        z-index: 0 !important;
    }
    
    /* Leaflet controls - TIDAK BOLEH DI ATAS UI LAIN */
    .leaflet-control-container {
        position: relative;
        z-index: 1 !important;
    }
    
    .leaflet-pane {
        z-index: 1 !important;
    }
    
    .leaflet-top,
    .leaflet-bottom {
        z-index: 1 !important;
    }
    
    /* Custom popup styling */
    .leaflet-popup-content-wrapper {
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .leaflet-popup-content {
        margin: 10px 12px;
    }
    
    .leaflet-popup-tip {
        background: white;
    }
    
    /* Dark mode untuk modal */
    @media (prefers-color-scheme: dark) {
        .leaflet-popup-content-wrapper {
            background-color: #374151;
            color: #f3f4f6;
        }
        
        .leaflet-popup-tip {
            background: #374151;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // ✅ INITIALIZE MAP
    @if($kegiatan->latitude && $kegiatan->longitude)
    document.addEventListener('DOMContentLoaded', function() {
        const lat = {{ $kegiatan->latitude }};
        const lng = {{ $kegiatan->longitude }};
        
        // Create map dengan z-index rendah
        const detailMap = L.map('detailMap', {
            scrollWheelZoom: true,
            dragging: true,
            touchZoom: true,
            doubleClickZoom: true,
            zoomControl: true
        }).setView([lat, lng], 18);

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19,
            minZoom: 5
        }).addTo(detailMap);

        // Add marker
        const marker = L.marker([lat, lng], {
            icon: L.icon({
                iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                shadowSize: [41, 41]
            }),
            title: '{{ $kegiatan->nama_kegiatan }}'
        }).addTo(detailMap);

        // Add popup
        const popupContent = `
            <div style="text-align: center; padding: 8px; min-width: 200px;">
                <strong style="font-size: 14px; color: #dc2626; display: block; margin-bottom: 8px;">
                    {{ $kegiatan->nama_kegiatan }}
                </strong>
                <span style="font-size: 12px; color: #4b5563; display: block; margin-bottom: 5px;">
                    📍 {{ $kegiatan->lokasi }}
                </span>
                @if($kegiatan->rincian_lokasi)
                    <span style="font-size: 11px; color: #6b7280; display: block;">
                        {{ $kegiatan->rincian_lokasi }}
                    </span>
                @endif
            </div>
        `;
        
        marker.bindPopup(popupContent, {
            maxWidth: 300,
            minWidth: 200
        });

        // Fix map size
        setTimeout(() => {
            detailMap.invalidateSize();
            detailMap.setView([lat, lng], 18);
        }, 100);

        // Recenter saat resize
        window.addEventListener('resize', function() {
            setTimeout(() => {
                detailMap.invalidateSize();
                detailMap.setView([lat, lng], detailMap.getZoom());
            }, 100);
        });
    });
    @endif

    // ✅ MODAL & DAFTAR FUNCTIONS
    function handleDaftar(kegiatanId, sudahDaftar) {
        if (sudahDaftar) {
            alert('Anda sudah terdaftar di kegiatan ini');
            return;
        }
        daftarKegiatan(kegiatanId);
    }

    function daftarKegiatan(kegiatanId) {
        const btn = document.getElementById('btnDaftar');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = 'Mendaftar...';
        btn.disabled = true;

        fetch(`/kegiatan/${kegiatanId}/daftar`, {
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
                showModal('modalSuccess');
            } else {
                alert(data.message || 'Gagal mendaftar');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mendaftar');
            btn.innerHTML = originalText;
            btn.disabled = false;
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

    // Close modal saat klik di luar
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