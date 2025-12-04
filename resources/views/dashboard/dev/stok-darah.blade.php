{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\dev\stok-darah.blade.php --}}
@extends('layouts.app')

@section('title', 'Stok Darah - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header with Filter --}}
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Stok Darah</h1>
                <p class="text-gray-600 mt-1">Kelola seluruh stok darah KSR PMI UNHAS</p>
            </div>
            
            {{-- Filter Jenis Darah --}}
            <div class="w-80">
                <label class="block text-sm font-medium text-gray-900 mb-2">Filter Jenis Darah</label>
                <form method="GET" action="{{ route('stok-darah.index') }}">
                    <select name="jenis_darah" 
                            onchange="this.form.submit()"
                            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent bg-white">
                        <option value="Semua" {{ $filterJenis == 'Semua' ? 'selected' : '' }}>Semua</option>
                        <option value="Darah Lengkap (Whole Blood)" {{ $filterJenis == 'Darah Lengkap (Whole Blood)' ? 'selected' : '' }}>
                            Darah Lengkap (Whole Blood)
                        </option>
                        <option value="Packed Red Cells (PRC)" {{ $filterJenis == 'Packed Red Cells (PRC)' ? 'selected' : '' }}>
                            Packed Red Cells (PRC)
                        </option>
                        <option value="Trombosit (TC)" {{ $filterJenis == 'Trombosit (TC)' ? 'selected' : '' }}>
                            Trombosit (TC)
                        </option>
                        <option value="Plasma" {{ $filterJenis == 'Plasma' ? 'selected' : '' }}>
                            Plasma
                        </option>
                    </select>
                </form>
            </div>
        </div>

        {{-- Grid Stok Darah --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            
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
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                {{-- Icon dan Angka dalam satu baris --}}
                <div class="flex items-center justify-between">
                    {{-- Icon di kiri --}}
                    <div class="flex-shrink-0">
                        @if(file_exists(public_path('images/' . $png)))
                            <img src="{{ asset('images/' . $png) }}" 
                                 alt="{{ $type }}" 
                                 class="w-14 h-14 object-contain">
                        @else
                            {{-- Fallback SVG --}}
                            <div class="w-14 h-14 flex items-center justify-center">
                                <svg class="w-14 h-14" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Blood bag body -->
                                    <rect x="16" y="16" width="24" height="32" rx="4" stroke="#DC2626" stroke-width="2.5" fill="white"/>
                                    
                                    <!-- Top tube -->
                                    <path d="M28 8L24 16H32L28 8Z" fill="#DC2626"/>
                                    <rect x="26" y="8" width="4" height="8" fill="#DC2626"/>
                                    
                                    <!-- Blood type text -->
                                    <text x="28" y="36" font-family="Arial, sans-serif" font-size="{{ strlen($type) > 2 ? '12' : '14' }}" font-weight="bold" fill="#DC2626" text-anchor="middle">{{ $type }}</text>
                                    
                                    <!-- Bottom drip -->
                                    <circle cx="28" cy="46" r="2" fill="#DC2626"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    {{-- Angka di kanan --}}
                    <div class="text-right">
                        <p class="text-3xl md:text-4xl font-bold text-red-600 leading-none mb-1">
                            {{ number_format($stokDarah[$type]) }}
                        </p>
                        <p class="text-xs text-green-600 font-semibold whitespace-nowrap">
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