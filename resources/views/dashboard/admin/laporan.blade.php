{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\admin\laporan.blade.php --}}
@extends('layouts.app')

@section('title', 'Laporan Statistik - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 sm:py-8 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white transition-colors">Laporan Statistik</h1>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-1 transition-colors">Kelola seluruh statistik donor darah KSR PMI UNHAS</p>
        </div>

        {{-- Charts Row --}}
        <div class="space-y-4 sm:space-y-6">
            
            {{-- Kantong Darah Terkumpul --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 sm:p-6 transition-colors">
                {{-- Header with Dropdown --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-4">
                    <h3 class="text-sm sm:text-base font-semibold text-gray-700 dark:text-gray-200 transition-colors">Kantong Darah Terkumpul</h3>
                    
                    {{-- Dropdown Filter --}}
                    <div class="relative inline-block w-full sm:w-auto">
                        <select id="periodFilter" class="appearance-none w-full sm:w-auto bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 sm:px-4 py-2 pr-10 text-xs sm:text-sm text-gray-700 dark:text-gray-200 hover:border-gray-400 dark:hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-transparent cursor-pointer transition-colors">
                            <option value="1">1 Bulan Terakhir</option>
                            <option value="3">3 Bulan Terakhir</option>
                            <option value="6" selected>6 Bulan Terakhir</option>
                            <option value="12">1 Tahun Terakhir</option>
                            <option value="24">2 Tahun Terakhir</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 sm:px-3 text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4 sm:mb-6">
                    <div class="text-4xl sm:text-5xl font-bold text-red-600 dark:text-red-500 transition-colors">{{ number_format($totalKantong) }}</div>
                    <p class="text-xs sm:text-sm text-green-600 dark:text-green-400 mt-2 transition-colors">
                        <span class="font-semibold">{{ $kantongBulanIni }}</span> bulan ini
                    </p>
                </div>
                
                @if($totalKantong > 0)
                    <div class="relative" style="height: 250px;">
                        <canvas id="chartTrenKantong"></canvas>
                    </div>
                    
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-4 transition-colors" id="chartDescription">
                        Puncak donasi terjadi pada bulan November.
                    </p>
                @else
                    <div class="relative border-t border-gray-200 dark:border-gray-700 pt-6 transition-colors" style="height: 200px;">
                        <div class="absolute bottom-0 left-0 right-0 flex justify-between text-xs text-gray-400 dark:text-gray-500 px-2 sm:px-4 transition-colors">
                            <span>Jul</span>
                            <span>Agu</span>
                            <span>Sep</span>
                            <span>Okt</span>
                            <span>Nov</span>
                            <span>Des</span>
                        </div>
                        <div class="absolute bottom-6 left-0 right-0 h-px bg-red-500 dark:bg-red-600"></div>
                    </div>
                    
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-4 transition-colors">
                        Tidak ada data untuk ditampilkan.
                    </p>
                @endif
            </div>

            {{-- Distribusi Golongan Darah Pendonor --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 sm:p-6 transition-colors">
                {{-- Header with Dropdown --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-4">
                    <h3 class="text-sm sm:text-base font-semibold text-gray-700 dark:text-gray-200 transition-colors">Distribusi Golongan Darah Pendonor</h3>
                    
                    {{-- Dropdown Filter --}}
                    <div class="relative inline-block w-full sm:w-auto">
                        <select id="goldarPeriodFilter" class="appearance-none w-full sm:w-auto bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-3 sm:px-4 py-2 pr-10 text-xs sm:text-sm text-gray-700 dark:text-gray-200 hover:border-gray-400 dark:hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-transparent cursor-pointer transition-colors">
                            <option value="1">1 Bulan Terakhir</option>
                            <option value="3">3 Bulan Terakhir</option>
                            <option value="6" selected>6 Bulan Terakhir</option>
                            <option value="12">1 Tahun Terakhir</option>
                            <option value="24">2 Tahun Terakhir</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 sm:px-3 text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4 sm:mb-6">
                    <div class="text-4xl sm:text-5xl font-bold text-red-600 dark:text-red-500 transition-colors" id="totalDonasiText">{{ number_format($totalDonasi) }}</div>
                    <p class="text-xs sm:text-sm text-green-600 dark:text-green-400 mt-2 transition-colors">
                        <span class="font-semibold">{{ $kantongBulanIni }}</span> bulan ini
                    </p>
                </div>
                
                <div class="flex items-center justify-center mb-4 sm:mb-6" style="height: 200px;">
                    <div class="relative w-full h-full flex items-center justify-center">
                        <canvas id="chartGolonganDarah"></canvas>
                        <div id="emptyGoldarChart" class="hidden absolute">
                            <svg viewBox="0 0 100 100" class="w-40 h-40 sm:w-52 sm:h-52">
                                <circle cx="50" cy="50" r="40" fill="none" stroke="#d1d5db" class="dark:stroke-gray-600" stroke-width="20"/>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-sm text-gray-400 dark:text-gray-500">0%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3" id="goldarLegend">
                    @foreach($distribusiGoldar as $goldar)
                    <div class="flex items-center">
                        <span class="w-3 h-3 rounded-full mr-2 flex-shrink-0" style="background-color: {{ 
                            str_starts_with($goldar['golongan'], 'O') ? '#ef4444' : 
                            (str_starts_with($goldar['golongan'], 'A') ? '#3b82f6' : 
                            (str_starts_with($goldar['golongan'], 'B') ? '#22c55e' : '#f59e0b')) 
                        }}"></span>
                        <span class="text-xs sm:text-sm dark:text-gray-300 transition-colors">
                            <span class="font-semibold">{{ $goldar['golongan'] }}</span> ({{ $goldar['persentase'] }}%)
                        </span>
                    </div>
                    @endforeach
                </div>
                
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 text-center mt-4 hidden transition-colors" id="emptyGoldarText">
                    Tidak ada data untuk ditampilkan.
                </p>
            </div>

        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Detect dark mode
    function isDarkMode() {
        return document.documentElement.classList.contains('dark');
    }

    // Get colors based on theme
    function getThemeColors() {
        const dark = isDarkMode();
        return {
            gridColor: dark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)',
            textColor: dark ? '#9ca3af' : '#6b7280',
            lineColor: dark ? '#ef4444' : '#ef4444',
            fillColor: dark ? 'rgba(239, 68, 68, 0.15)' : 'rgba(239, 68, 68, 0.1)',
            tooltipBg: dark ? 'rgba(31, 41, 55, 0.95)' : 'rgba(0, 0, 0, 0.8)',
        };
    }

    @if($totalKantong > 0)
    // Data lengkap dari backend (semua periode)
    const allTrenData = @json($trenKantong);
    let chartInstance = null;

    // Fungsi untuk update chart berdasarkan periode
    function updateChart(months) {
        const filteredData = allTrenData.slice(-months);
        const colors = getThemeColors();
        
        if (chartInstance) {
            chartInstance.destroy();
        }
        
        const ctxTren = document.getElementById('chartTrenKantong').getContext('2d');
        chartInstance = new Chart(ctxTren, {
            type: 'line',
            data: {
                labels: filteredData.map(item => item.bulan),
                datasets: [{
                    label: 'Kantong Terkumpul',
                    data: filteredData.map(item => item.jumlah),
                    borderColor: colors.lineColor,
                    backgroundColor: colors.fillColor,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: colors.lineColor,
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
                        backgroundColor: colors.tooltipBg,
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
                            stepSize: 50,
                            color: colors.textColor
                        },
                        grid: {
                            color: colors.gridColor
                        }
                    },
                    x: {
                        ticks: {
                            color: colors.textColor
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        updateDescription(filteredData);
    }

    function updateDescription(data) {
        if (data.length === 0) return;
        
        const maxValue = Math.max(...data.map(item => item.jumlah));
        const maxMonth = data.find(item => item.jumlah === maxValue);
        
        const description = document.getElementById('chartDescription');
        if (maxMonth && maxValue > 0) {
            description.textContent = `Puncak donasi terjadi pada bulan ${maxMonth.bulan} dengan ${maxValue} kantong.`;
        } else {
            description.textContent = 'Belum ada data donasi.';
        }
    }

    document.getElementById('periodFilter').addEventListener('change', function() {
        const selectedMonths = parseInt(this.value);
        updateChart(selectedMonths);
    });

    // Watch for theme changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                const currentPeriod = parseInt(document.getElementById('periodFilter').value);
                updateChart(currentPeriod);
                
                @if($totalDonasi > 0)
                const currentGoldarPeriod = parseInt(document.getElementById('goldarPeriodFilter').value);
                updateGoldarChart(currentGoldarPeriod);
                @endif
            }
        });
    });
    observer.observe(document.documentElement, { attributes: true });

    updateChart(6);
    @endif

    @if($totalDonasi > 0)
    // Data distribusi golongan darah untuk semua periode
    const allGoldarData = {!! json_encode($distribusiGoldarPeriode) !!};
    let goldarChartInstance = null;

    // Warna berdasarkan golongan darah
    const colorMap = {
        'O+': '#ef4444', 'O-': '#dc2626',
        'A+': '#3b82f6', 'A-': '#2563eb',
        'B+': '#22c55e', 'B-': '#16a34a',
        'AB+': '#f59e0b', 'AB-': '#d97706'
    };

    // Fungsi untuk update chart golongan darah
    function updateGoldarChart(months) {
        const data = allGoldarData[months];
        const colors = getThemeColors();
        
        const chartCanvas = document.getElementById('chartGolonganDarah');
        const emptyChart = document.getElementById('emptyGoldarChart');
        const emptyText = document.getElementById('emptyGoldarText');
        const legendContainer = document.getElementById('goldarLegend');
        
        // Jika tidak ada data atau data kosong
        if (!data || !data.distribusi || data.distribusi.length === 0 || data.total === 0) {
            // Sembunyikan chart canvas
            chartCanvas.style.display = 'none';
            // Tampilkan empty state
            emptyChart.classList.remove('hidden');
            emptyText.classList.remove('hidden');
            // Kosongkan legend
            legendContainer.innerHTML = '';
            // Update total jadi 0
            document.getElementById('totalDonasiText').textContent = '0';
            
            // Destroy chart jika ada
            if (goldarChartInstance) {
                goldarChartInstance.destroy();
                goldarChartInstance = null;
            }
            
            return;
        }

        // Jika ada data, tampilkan chart
        chartCanvas.style.display = 'block';
        emptyChart.classList.add('hidden');
        emptyText.classList.add('hidden');

        // Update total donasi
        document.getElementById('totalDonasiText').textContent = data.total.toLocaleString('id-ID');

        const chartColors = data.distribusi.map(item => colorMap[item.golongan] || '#6b7280');

        if (goldarChartInstance) {
            goldarChartInstance.destroy();
        }

        const ctxGoldar = chartCanvas.getContext('2d');
        goldarChartInstance = new Chart(ctxGoldar, {
            type: 'doughnut',
            data: {
                labels: data.distribusi.map(item => item.golongan),
                datasets: [{
                    data: data.distribusi.map(item => item.total),
                    backgroundColor: chartColors,
                    borderWidth: 2,
                    borderColor: isDarkMode() ? '#1f2937' : '#fff'
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
                        backgroundColor: colors.tooltipBg,
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

        // Update legend
        updateGoldarLegend(data.distribusi);
    }

    // Fungsi untuk update legend
    function updateGoldarLegend(distribusi) {
        const legendContainer = document.getElementById('goldarLegend');
        legendContainer.innerHTML = '';

        distribusi.forEach(goldar => {
            const color = colorMap[goldar.golongan] || '#6b7280';
            const legendItem = `
                <div class="flex items-center">
                    <span class="w-3 h-3 rounded-full mr-2 flex-shrink-0" style="background-color: ${color}"></span>
                    <span class="text-xs sm:text-sm dark:text-gray-300 transition-colors">
                        <span class="font-semibold">${goldar.golongan}</span> (${goldar.persentase}%)
                    </span>
                </div>
            `;
            legendContainer.innerHTML += legendItem;
        });
    }

    // Event listener untuk dropdown golongan darah
    document.getElementById('goldarPeriodFilter').addEventListener('change', function() {
        const selectedMonths = parseInt(this.value);
        updateGoldarChart(selectedMonths);
    });

    // Inisialisasi chart pertama kali (default 6 bulan)
    updateGoldarChart(6);
    @endif
</script>
@endpush
@endsection