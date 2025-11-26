{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\admin\laporan.blade.php --}}
@extends('layouts.app')

@section('title', 'Laporan Statistik - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Laporan Statistik</h1>
            <p class="text-gray-600 mt-1">Kelola seluruh statistik donor darah KSR PMI UNHAS</p>
        </div>

        {{-- Charts Row --}}
        <div class="space-y-6">
            
            {{-- Kantong Darah Terkumpul (6 Bulan Terakhir) --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-semibold text-gray-700 mb-4">Kantong Darah Terkumpul (6 Bulan Terakhir)</h3>
                
                <div class="mb-6">
                    <div class="text-5xl font-bold text-red-600">{{ number_format($totalKantong) }}</div>
                    <p class="text-sm text-green-600 mt-2">
                        <span class="font-semibold">{{ $kantongBulanIni }}</span> bulan ini
                    </p>
                </div>
                
                @if($totalKantong > 0)
                    <div class="relative" style="height: 300px;">
                        <canvas id="chartTrenKantong"></canvas>
                    </div>
                    
                    <p class="text-sm text-gray-500 mt-4">
                        Puncak donasi terjadi pada bulan November.
                    </p>
                @else
                    <div class="relative border-t border-gray-200 pt-6" style="height: 250px;">
                        {{-- X-axis labels --}}
                        <div class="absolute bottom-0 left-0 right-0 flex justify-between text-xs text-gray-400 px-4">
                            <span>Jul</span>
                            <span>Agu</span>
                            <span>Sep</span>
                            <span>Okt</span>
                            <span>Nov</span>
                            <span>Des</span>
                        </div>
                        
                        {{-- Horizontal line --}}
                        <div class="absolute bottom-6 left-0 right-0 h-px bg-red-500"></div>
                    </div>
                    
                    <p class="text-sm text-gray-500 mt-4">
                        Tidak ada data untuk ditampilkan.
                    </p>
                @endif
            </div>

            {{-- Distribusi Golongan Darah Pendonor --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-semibold text-gray-700 mb-4">Distribusi Golongan Darah Pendonor</h3>
                
                <div class="mb-6">
                    <div class="text-5xl font-bold text-red-600">{{ number_format($totalDonasi) }}</div>
                    <p class="text-sm text-green-600 mt-2">
                        <span class="font-semibold">{{ $kantongBulanIni }}</span> bulan ini
                    </p>
                </div>
                
                @if($totalDonasi > 0)
                    <div class="flex items-center justify-center mb-6" style="height: 280px;">
                        <canvas id="chartGolonganDarah"></canvas>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($distribusiGoldar as $goldar)
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ 
                                $goldar['golongan'] == 'O' ? '#ef4444' : 
                                ($goldar['golongan'] == 'A' ? '#3b82f6' : 
                                ($goldar['golongan'] == 'B' ? '#22c55e' : '#f59e0b')) 
                            }}"></span>
                            <span class="text-sm">
                                <span class="font-semibold">{{ $goldar['golongan'] }}</span> ({{ $goldar['persentase'] }}%)
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center mb-6" style="height: 280px;">
                        {{-- Empty Doughnut Chart --}}
                        <div class="relative w-52 h-52">
                            <svg viewBox="0 0 100 100" class="w-full h-full">
                                <circle cx="50" cy="50" r="40" fill="none" stroke="#d1d5db" stroke-width="20"/>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-sm text-gray-400">0%</span>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-sm text-gray-500 text-center">
                        Tidak ada data untuk ditampilkan.
                    </p>
                @endif
            </div>

        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if($totalKantong > 0)
    // Data dari backend
    const trenKantongData = @json($trenKantong);

    // Chart Tren Kantong Darah
    const ctxTren = document.getElementById('chartTrenKantong').getContext('2d');
    new Chart(ctxTren, {
        type: 'line',
        data: {
            labels: trenKantongData.map(item => item.bulan),
            datasets: [{
                label: 'Kantong Terkumpul',
                data: trenKantongData.map(item => item.jumlah),
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#ef4444',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    callbacks: {
                        label: function(context) {
                            return 'Kantong: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    @endif

    @if($totalDonasi > 0)
    const distribusiGoldarData = @json($distribusiGoldar);

    // Chart Distribusi Golongan Darah
    const ctxGoldar = document.getElementById('chartGolonganDarah').getContext('2d');
    new Chart(ctxGoldar, {
        type: 'doughnut',
        data: {
            labels: distribusiGoldarData.map(item => item.golongan),
            datasets: [{
                data: distribusiGoldarData.map(item => item.total),
                backgroundColor: [
                    '#ef4444', // O - Merah
                    '#3b82f6', // A - Biru
                    '#22c55e', // B - Hijau
                    '#f59e0b'  // AB - Orange
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(0);
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
    @endif
</script>
@endpush
@endsection