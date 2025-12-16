@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors">
    <!-- Header Section -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 transition-colors">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Tentang KSR PMI UNHAS</h1>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mt-2">Korps Sukarela Palang Merah Indonesia Universitas Hasanuddin Makassar</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
        
        <!-- Hero Section with Logo & History -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 mb-8 sm:mb-12">
            <!-- Logo - ✅ BACKGROUND DISAMAKAN DENGAN LATAR -->
            <div class="flex items-center justify-center p-6 sm:p-8 bg-gray-50 dark:bg-gray-900 rounded-lg transition-colors">
                <img src="{{ asset('images/logo-ksr-pmi.png') }}" 
                     alt="KSR PMI UNHAS Logo" 
                     class="w-48 h-48 sm:w-64 sm:h-64 object-contain"
                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22256%22 height=%22256%22 viewBox=%220 0 256 256%22%3E%3Ccircle cx=%22128%22 cy=%22128%22 r=%22128%22 fill=%22%23dc2626%22/%3E%3Cpath d=%22M128 50 L148 110 L210 110 L160 150 L180 210 L128 170 L76 210 L96 150 L46 110 L108 110 Z%22 fill=%22white%22/%3E%3C/svg%3E'">
            </div>

            <!-- History Text -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 sm:p-8 transition-colors">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-4">Sejarah Kami</h2>
                <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300 leading-relaxed mb-4 text-justify">
                    KSR PMI UNHAS Makassar didirikan sebagai wadah bagi mahasiswa Universitas Hasanuddin yang ingin berkontribusi dalam kegiatan kemanusiaan. Terbentuknya wadah ini merupakan bentuk komitmen kami untuk terus mengembangkan semangat kemanusiaan dan memberikan pelayanan kepada masyarakat.
                </p>
                <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300 leading-relaxed text-justify">
                    Sejak berdirinya, KSR PMI UNHAS telah melakukan berbagai kegiatan sosial yang berfokus pada pemberdayaan masyarakat dan peningkatan kesadaran kesehatan di wilayah Makassar dan sekitarnya.
                </p>
            </div>
        </div>

        <!-- ...existing code untuk Visi & Misi... -->
        <!-- Visi & Misi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-8 sm:mb-12">
            <!-- Visi -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-xl p-5 sm:p-6 hover:shadow-lg dark:hover:shadow-2xl transition-all">
                <div class="flex items-center mb-4">
                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-red-100 dark:bg-red-900/30 mr-3 flex-shrink-0">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Visi</h3>
                </div>
                <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300 leading-relaxed text-justify">
                    Menjadi organisasi kemanusiaan yang unggul dalam gerakan kesehatan PMI dan dedikasi donor darah serta pelayanan kemanusiaan kepada masyarakat.
                </p>
            </div>

            <!-- Misi -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-xl p-5 sm:p-6 hover:shadow-lg dark:hover:shadow-2xl transition-all">
                <div class="flex items-center mb-4">
                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-red-100 dark:bg-red-900/30 mr-3 flex-shrink-0">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Misi</h3>
                </div>
                <ul class="text-sm sm:text-base text-gray-700 dark:text-gray-300 space-y-2 sm:space-y-3">
                    <li class="flex items-start">
                        <span class="text-red-600 dark:text-red-400 mr-2 mt-1 flex-shrink-0">•</span>
                        <span class="text-justify">Meningkatkan kesadaran masyarakat tentang pentingnya donor darah</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-red-600 dark:text-red-400 mr-2 mt-1 flex-shrink-0">•</span>
                        <span class="text-justify">Memfasilitasi kegiatan donor darah secara berkala</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-red-600 dark:text-red-400 mr-2 mt-1 flex-shrink-0">•</span>
                        <span class="text-justify">Memberikan pelatihan kesehatan kepada masyarakat</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-red-600 dark:text-red-400 mr-2 mt-1 flex-shrink-0">•</span>
                        <span class="text-justify">Melaksanakan program kesehatan dan pemberdayaan masyarakat</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- ...existing code untuk Nilai-Nilai & Statistics... -->
        <!-- Nilai-Nilai Kami -->
        <div class="mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2 text-center">Nilai-Nilai Kami</h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 text-center mb-6 sm:mb-8 px-4">Dalam menggerakkan kegiatan, kami berpegang pada nilai-nilai donor PMI</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Kemanusiaan -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-xl p-5 sm:p-6 text-center hover:shadow-lg dark:hover:shadow-2xl transition-all">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 mx-auto mb-4">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-2">Kemanusiaan</h3>
                    <p class="text-xs sm:text-sm text-gray-700 dark:text-gray-300">Mengutamakan kepentingan kemanusiaan dalam setiap tindakan</p>
                </div>

                <!-- Kedamaian -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-xl p-5 sm:p-6 text-center hover:shadow-lg dark:hover:shadow-2xl transition-all">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 mx-auto mb-4">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-2">Kedamaian</h3>
                    <p class="text-xs sm:text-sm text-gray-700 dark:text-gray-300">Mempromosikan kedamaian dan mencegah kekerasan</p>
                </div>

                <!-- Netral -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-xl p-5 sm:p-6 text-center hover:shadow-lg dark:hover:shadow-2xl transition-all">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 mx-auto mb-4">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-2">Netral</h3>
                    <p class="text-xs sm:text-sm text-gray-700 dark:text-gray-300">Tidak memihak pada kelompok apapun tanpa diskriminasi</p>
                </div>

                <!-- Profesional -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-xl p-5 sm:p-6 text-center hover:shadow-lg dark:hover:shadow-2xl transition-all">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 mx-auto mb-4">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-2">Profesional</h3>
                    <p class="text-xs sm:text-sm text-gray-700 dark:text-gray-300">Bekerja dengan standar profesional yang tinggi</p>
                </div>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="bg-gradient-to-br from-red-600 via-red-700 to-red-800 dark:from-red-800 dark:via-red-900 dark:to-gray-900 rounded-lg shadow-lg dark:shadow-xl p-6 sm:p-8 text-white mb-8 sm:mb-12 transition-all">
            <div class="flex items-center justify-center mb-4 sm:mb-6">
                <svg class="h-6 w-6 sm:h-8 sm:w-8 mr-2 sm:mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                </svg>
                <h2 class="text-xl sm:text-2xl font-bold">Pencapaian Kami</h2>
            </div>
            <p class="text-center mb-6 sm:mb-8 text-sm sm:text-base text-red-100 dark:text-red-200 px-4">Dedikasi kami dalam melayani masyarakat</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 sm:gap-8 text-center">
                <div class="bg-white/10 dark:bg-black/20 backdrop-blur-sm rounded-lg p-4 sm:p-6 hover:bg-white/20 dark:hover:bg-black/30 transition-all">
                    <div class="text-3xl sm:text-4xl md:text-5xl font-bold mb-2">12+</div>
                    <p class="text-xs sm:text-sm text-red-100 dark:text-red-200">Tahun Berdiri</p>
                </div>
                <div class="bg-white/10 dark:bg-black/20 backdrop-blur-sm rounded-lg p-4 sm:p-6 hover:bg-white/20 dark:hover:bg-black/30 transition-all">
                    <div class="text-3xl sm:text-4xl md:text-5xl font-bold mb-2">5000+</div>
                    <p class="text-xs sm:text-sm text-red-100 dark:text-red-200">Pendonor Terdaftar</p>
                </div>
                <div class="bg-white/10 dark:bg-black/20 backdrop-blur-sm rounded-lg p-4 sm:p-6 hover:bg-white/20 dark:hover:bg-black/30 transition-all">
                    <div class="text-3xl sm:text-4xl md:text-5xl font-bold mb-2">100+</div>
                    <p class="text-xs sm:text-sm text-red-100 dark:text-red-200">Kegiatan Per Tahun</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection