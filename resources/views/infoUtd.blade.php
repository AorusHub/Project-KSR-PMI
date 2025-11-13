@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900">Informasi UTD/PMI Makassar</h1>
            <p class="text-gray-600 mt-2">Lokasi Unit Transfusi Darah dan Bank Darah di wilayah Makassar dan sekitarnya</p>
        </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($utds as $utd)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">{{ $utd->name }}</h3>
                    
                    {{-- Alamat --}}
                    <div class="flex items-start mb-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-700 mb-1">Alamat</p>
                            <p class="text-sm text-gray-600">{{ $utd->address }}</p>
                        </div>
                    </div>

                    {{-- Telepon --}}
                    @if(!empty($utd->phone))
                    <div class="flex items-start mb-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-700 mb-1">Telepon</p>
                            <a href="tel:{{ $utd->phone }}" class="text-sm text-blue-600 hover:text-blue-800">{{ $utd->phone }}</a>
                        </div>
                    </div>
                    @endif

                    {{-- Jam Operasional --}}
                    @if(!empty($utd->hours))
                    <div class="flex items-start mb-4">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-700 mb-1">Jam Operasional</p>
                            <p class="text-sm text-gray-600">{{ $utd->hours }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Layanan --}}
                    @if(!empty($utd->services) && count((array)$utd->services))
                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm font-medium text-gray-700 mb-2">Layanan:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($utd->services as $service)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
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
        <div class="mt-12 bg-blue-50 border-l-4 border-blue-400 rounded-lg p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h4 class="text-base font-semibold text-blue-900 mb-3">Informasi Penting</h4>
                    <ul class="space-y-2 text-sm text-blue-800">
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Pastikan membawa identitas diri (KTP/SIM/Kartu Pelajar) saat akan melakukan donor atau mengambil darah.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Untuk permintaan darah darurat, hubungi nomor telepon UTD terdekat atau call center PMI: <strong>119</strong>.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Stok darah dapat berubah sewaktu-waktu; disarankan untuk menghubungi terlebih dahulu sebelum datang.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Beberapa lokasi mungkin memerlukan surat permintaan darah dari rumah sakit.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection