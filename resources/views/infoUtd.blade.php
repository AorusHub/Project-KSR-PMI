{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\infoUtd.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        
        {{-- Header --}}
        <div class="text-center mb-8 sm:mb-12">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-3">
                Informasi UTD/PMI Makassar
            </h1>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 px-4">
                Lokasi Unit Transfusi Darah dan Bank Darah di wilayah Makassar dan sekitarnya
            </p>
        </div>

        {{-- UTD Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 lg:gap-8">
            @foreach($utds as $utd)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl dark:shadow-gray-900/50 transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-5 sm:p-6">
                    {{-- Nama UTD --}}
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-5">
                        {{ $utd->name }}
                    </h3>
                    
                    {{-- Alamat --}}
                    <div class="flex items-start mb-3 sm:mb-4">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                Alamat
                            </p>
                            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 leading-relaxed">
                                {{ $utd->address }}
                            </p>
                        </div>
                    </div>

                    {{-- Telepon --}}
                    @if(!empty($utd->phone))
                    <div class="flex items-start mb-3 sm:mb-4">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                Telepon
                            </p>
                            <a href="tel:{{ $utd->phone }}" 
                               class="text-sm sm:text-base text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors font-medium">
                                {{ $utd->phone }}
                            </a>
                        </div>
                    </div>
                    @endif

                    {{-- Jam Operasional --}}
                    @if(!empty($utd->hours))
                    <div class="flex items-start mb-4 sm:mb-5">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                Jam Operasional
                            </p>
                            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">
                                {{ $utd->hours }}
                            </p>
                        </div>
                    </div>
                    @endif

                    {{-- Layanan --}}
                    @if(!empty($utd->services) && count((array)$utd->services))
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 sm:mb-3">
                            Layanan:
                        </p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($utd->services as $service)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 border border-red-200 dark:border-red-800">
                                {{ $service }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        {{-- Informasi Penting --}}
        <div class="mt-8 sm:mt-12 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 dark:border-blue-500 rounded-lg p-5 sm:p-6 lg:p-8 shadow-sm">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 sm:h-7 sm:w-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3 sm:ml-4 flex-1">
                    <h4 class="text-base sm:text-lg font-bold text-blue-900 dark:text-blue-300 mb-3 sm:mb-4">
                        Informasi Penting
                    </h4>
                    <ul class="space-y-2 sm:space-y-3 text-sm sm:text-base text-blue-800 dark:text-blue-200">
                        <li class="flex items-start">
                            <span class="mr-2 flex-shrink-0 font-bold">•</span>
                            <span class="leading-relaxed">
                                Pastikan membawa identitas diri (KTP/SIM/Kartu Pelajar) saat akan melakukan donor atau mengambil darah.
                            </span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2 flex-shrink-0 font-bold">•</span>
                            <span class="leading-relaxed">
                                Untuk permintaan darah darurat, hubungi nomor telepon UTD terdekat atau call center PMI: 
                                <a href="tel:119" class="font-bold text-blue-900 dark:text-blue-300 hover:text-blue-700 dark:hover:text-blue-200 underline">119</a>.
                            </span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2 flex-shrink-0 font-bold">•</span>
                            <span class="leading-relaxed">
                                Stok darah dapat berubah sewaktu-waktu; disarankan untuk menghubungi terlebih dahulu sebelum datang.
                            </span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2 flex-shrink-0 font-bold">•</span>
                            <span class="leading-relaxed">
                                Beberapa lokasi mungkin memerlukan surat permintaan darah dari rumah sakit.
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection