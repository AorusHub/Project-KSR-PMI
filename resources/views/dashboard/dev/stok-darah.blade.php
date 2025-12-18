{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\dev\stok-darah.blade.php --}}
@extends('layouts.app')

@section('title', 'Stok Darah - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-4 sm:py-6 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header with Filter --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-0 mb-4 sm:mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white transition-colors">Stok Darah</h1>
                <p class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm mt-1 transition-colors">Kelola seluruh stok darah KSR PMI UNHAS</p>
            </div>
            
            {{-- Filter Jenis Darah --}}
            <div class="w-full sm:w-72">
                <label class="block text-xs sm:text-sm font-medium text-gray-900 dark:text-white mb-2 transition-colors">Filter Jenis Darah</label>
                <form method="GET" action="{{ route('stok-darah.index') }}">
                    <select name="jenis_darah" 
                            onchange="this.form.submit()"
                            class="w-full px-3 sm:px-4 py-2 text-xs sm:text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-transparent bg-white dark:bg-gray-800 text-gray-900 dark:text-white transition-colors">
                        <option value="Semua" {{ $filterJenis == 'Semua' ? 'selected' : '' }} class="dark:bg-gray-800">Semua</option>
                        <option value="Darah Lengkap (Whole Blood)" {{ $filterJenis == 'Darah Lengkap (Whole Blood)' ? 'selected' : '' }} class="dark:bg-gray-800">
                            Darah Lengkap (Whole Blood)
                        </option>
                        <option value="Packed Red Cells (PRC)" {{ $filterJenis == 'Packed Red Cells (PRC)' ? 'selected' : '' }} class="dark:bg-gray-800">
                            Packed Red Cells (PRC)
                        </option>
                        <option value="Trombosit (TC)" {{ $filterJenis == 'Trombosit (TC)' ? 'selected' : '' }} class="dark:bg-gray-800">
                            Trombosit (TC)
                        </option>
                        <option value="Plasma" {{ $filterJenis == 'Plasma' ? 'selected' : '' }} class="dark:bg-gray-800">
                            Plasma
                        </option>
                    </select>
                </form>
            </div>
        </div>

        {{-- Grid Stok Darah --}}
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 pb-4 sm:pb-6">
            
            @php
            $bloodTypes = [
                'A+' => 'a-plus.png',
                'B+' => 'b-plus.png',
                'O+' => 'o-plus.png',
                'AB+' => 'ab-plus.png',
                'A-' => 'a-minus.png',
                'B-' => 'b-minus.png',
                'O-' => 'o-minus.png',
                'AB-' => 'ab-minus.png',
            ];
            @endphp

            @foreach($bloodTypes as $type => $png)
            <div class="bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl shadow-sm dark:shadow-gray-900/50 border border-gray-100 dark:border-gray-700 p-4 sm:p-5 transition-all hover:shadow-md dark:hover:shadow-gray-900/70">
                {{-- Icon dan Angka dalam satu baris --}}
                <div class="flex items-center justify-between">
                    {{-- Icon di kiri --}}
                    <div class="flex-shrink-0">
                        @if(file_exists(public_path('images/' . $png)))
                            <img src="{{ asset('images/' . $png) }}" 
                                 alt="{{ $type }}" 
                                 class="w-10 h-10 sm:w-12 sm:h-12 object-contain">
                        @else
                            {{-- Fallback SVG --}}
                            <div class="w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center">
                                <svg class="w-10 h-10 sm:w-12 sm:h-12" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="16" y="16" width="24" height="32" rx="4" stroke="#DC2626" class="dark:stroke-red-500" stroke-width="2.5" fill="white" class="dark:fill-gray-700"/>
                                    <path d="M28 8L24 16H32L28 8Z" fill="#DC2626" class="dark:fill-red-500"/>
                                    <rect x="26" y="8" width="4" height="8" fill="#DC2626" class="dark:fill-red-500"/>
                                    <text x="28" y="36" font-family="Arial, sans-serif" font-size="{{ strlen($type) > 2 ? '12' : '14' }}" font-weight="bold" fill="#DC2626" class="dark:fill-red-400" text-anchor="middle">{{ $type }}</text>
                                    <circle cx="28" cy="46" r="2" fill="#DC2626" class="dark:fill-red-500"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    {{-- Angka di kanan --}}
                    <div class="text-right">
                        <p class="text-2xl sm:text-3xl font-bold text-red-600 dark:text-red-500 leading-none mb-1 transition-colors">
                            {{ number_format($stokDarah[$type]) }}
                        </p>
                        <p class="text-[10px] sm:text-xs text-green-600 dark:text-green-400 font-semibold whitespace-nowrap transition-colors">
                            +{{ $perubahanBulanIni[$type] }} bulan ini
                        </p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection