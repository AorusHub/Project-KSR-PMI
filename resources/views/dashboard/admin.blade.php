<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Admin KSR PMI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pendonor</div>
                        </div>
                        <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ $totalPendonor }}
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Kegiatan</div>
                        </div>
                        <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ $totalKegiatan }}
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Permintaan</div>
                        </div>
                        <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ $totalPermintaan }}
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Donasi</div>
                        </div>
                        <div class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ $totalDonasi }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kegiatan Terbaru -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Kegiatan Terbaru</h3>
                        <div class="space-y-3">
                            @forelse($kegiatanTerbaru as $kegiatan)
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $kegiatan->nama_kegiatan }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $kegiatan->tanggal->format('d M Y') }} - {{ $kegiatan->lokasi }}
                                    </div>
                                    <div class="text-xs text-gray-400">Status: {{ $kegiatan->status }}</div>
                                </div>
                            @empty
                                <p class="text-gray-500 dark:text-gray-400">Belum ada kegiatan</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Permintaan Pending -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Permintaan Pending</h3>
                        <div class="space-y-3">
                            @forelse($permintaanPending as $permintaan)
                                <div class="border-l-4 border-yellow-500 pl-4">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $permintaan->nama_pasien }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Golongan Darah: {{ $permintaan->golongan_darah }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Rumah Sakit: {{ $permintaan->rumah_sakit }}
                                    </div>
                                    <div class="text-xs text-gray-400">{{ $permintaan->created_at->diffForHumans() }}</div>
                                </div>
                            @empty
                                <p class="text-gray-500 dark:text-gray-400">Tidak ada permintaan pending</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>