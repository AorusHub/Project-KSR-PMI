@extends('layouts.app')

@section('title', 'Partisipan - ' . $kegiatan->nama_kegiatan)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4">
        
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('kegiatan.show', $kegiatan->kegiatan_id) }}" 
               class="inline-flex items-center text-gray-700 hover:text-gray-900">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Detail Kegiatan
            </a>
        </div>

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-1">Partisipan</h1>
            <p class="text-gray-600">{{ $kegiatan->nama_kegiatan }}</p>
        </div>

        {{-- Search Card --}}
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <form action="{{ route('kegiatan.peserta.search', $kegiatan->kegiatan_id) }}" method="GET">
                <label class="block text-sm font-semibold text-gray-900 mb-3">Cari Partisipan</label>
                <div class="flex gap-3">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               name="search" 
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" 
                               placeholder="Cari berdasarkan nama..."
                               value="{{ $search ?? '' }}">
                    </div>
                    <button type="submit" class="px-8 py-2.5 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                        CARI
                    </button>
                </div>
            </form>
        </div>

        {{-- Partisipan Table --}}
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Daftar Partisipan</h2>
            
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Pengguna</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Gol. Darah</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">No. HP</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Member</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($partisipans as $index => $partisipan)
                                {{-- ✅ CEK DULU apakah pendonor dan user ada --}}
                                @if($partisipan->pendonor && $partisipan->pendonor->user)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $partisipans->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $partisipan->pendonor->user->nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $golDarah = $partisipan->pendonor->golongan_darah ?? '-';
                                            $badgeColor = match(str_replace(['+', '-'], '', $golDarah)) {
                                                'A' => 'bg-red-100 text-red-700',
                                                'B' => 'bg-orange-100 text-orange-700',
                                                'AB' => 'bg-red-100 text-red-700',
                                                'O' => 'bg-red-100 text-red-700',
                                                default => 'bg-gray-100 text-gray-700'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $badgeColor }}">
                                            {{ $golDarah }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $partisipan->pendonor->user->email ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $partisipan->pendonor->user->no_telepon ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{-- ✅ CEK created_at ada --}}
                                        Sejak {{ $partisipan->pendonor->created_at ? $partisipan->pendonor->created_at->format('Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <button class="px-4 py-2 bg-gray-400 text-white text-sm font-medium rounded-lg hover:bg-gray-500 transition-colors">
                                            Lihat Detail Pendonor
                                        </button>
                                    </td>
                                </tr>
                                @endif
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    <p class="text-gray-500 text-sm">Belum ada partisipan terdaftar</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

             {{-- ✅ CUSTOM PAGINATION --}}
            @if($partisipans->hasPages())
            <div class="mt-6">
                <nav class="flex items-center justify-center">
                    <div class="flex items-center space-x-1">
                        {{-- Previous Button --}}
                        @if ($partisipans->onFirstPage())
                            <span class="px-3 py-2 text-gray-400 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </span>
                        @else
                            <a href="{{ $partisipans->previousPageUrl() }}" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($partisipans->getUrlRange(1, $partisipans->lastPage()) as $page => $url)
                            @if ($page == $partisipans->currentPage())
                                <span class="px-4 py-2 text-sm font-bold text-white bg-red-600 border border-red-600 rounded-lg">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if ($partisipans->hasMorePages())
                            <a href="{{ $partisipans->nextPageUrl() }}" class="px-3 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @else
                            <span class="px-3 py-2 text-gray-400 bg-white border border-gray-300 rounded-lg cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        @endif
                    </div>
                </nav>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection