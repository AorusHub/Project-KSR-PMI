@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white border-b">
        <div class="max-w-6xl mx-auto px-4 py-8">
            <h1 class="text-2xl font-bold text-gray-900">Tentang KSR PMI UNHAS</h1>
            <p class="text-gray-600 mt-2">Korps Sukarela Palang Merah Indonesia Universitas Hasanuddin Makassar</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-12">
        
        <!-- Hero Section with Logo & History -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Logo -->
            <div class="flex items-center justify-center">
                <img src="{{ asset('images/ksr-logo.png') }}" alt="KSR PMI UNHAS Logo" class="w-64 h-64 object-contain">
            </div>

            <!-- History Text -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Sejarah Kami</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    KSR PMI UNHAS Makassar didirikan sebagai wadah bagi mahasiswa Universitas Hasanuddin yang ingin berkontribusi dalam kegiatan kemanusiaan. Terbentuknya wadah ini merupakan bentuk komitmen kami untuk terus mengembangkan semangat kemanusiaan dan memberikan pelayanan kepada masyarakat.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    Sejak berdirinya, KSR PMI UNHAS telah melakukan berbagai kegiatan sosial yang berfokus pada pemberdayaan masyarakat dan peningkatan kesadaran kesehatan di wilayah Makassar dan sekitarnya.
                </p>
            </div>
        </div>

        <!-- Visi & Misi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            <!-- Visi -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center mb-4">
                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-red-100 mr-3">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Visi</h3>
                </div>
                <p class="text-gray-700 leading-relaxed">
                    Menjadi organisasi kemanusiaan yang unggul dalam gerakan kesehatan PMI dan dedikasi donor darah serta pelayanan kemanusiaan kepada masyarakat.
                </p>
            </div>

            <!-- Misi -->
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                <div class="flex items-center mb-4">
                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-red-100 mr-3">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Misi</h3>
                </div>
                <ul class="text-gray-700 space-y-2">
                    <li class="flex items-start">
                        <span class="text-red-600 mr-2">•</span>
                        <span>Meningkatkan kesadaran masyarakat tentang pentingnya donor darah</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-red-600 mr-2">•</span>
                        <span>Memfasilitasi kegiatan donor darah secara berkala</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-red-600 mr-2">•</span>
                        <span>Memberikan pelatihan kesehatan kepada masyarakat</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-red-600 mr-2">•</span>
                        <span>Melaksanakan program kesehatan dan pemberdayaan masyarakat</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Nilai-Nilai Kami -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center">Nilai-Nilai Kami</h2>
            <p class="text-gray-600 text-center mb-8">Dalam menggerakkan kegiatan, kami berpegang pada nilai-nilai donor PMI</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Kemanusiaan -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mx-auto mb-4">
                        <svg class="h-6 w-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Kemanusiaan</h3>
                    <p class="text-gray-700 text-sm">Mengutamakan kepentingan kemanusiaan dalam setiap tindakan</p>
                </div>

                <!-- Kedamaian -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mx-auto mb-4">
                        <svg class="h-6 w-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Kedamaian</h3>
                    <p class="text-gray-700 text-sm">Mempromosikan kedamaian dan mencegah kekerasan</p>
                </div>

                <!-- Netral -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mx-auto mb-4">
                        <svg class="h-6 w-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Netral</h3>
                    <p class="text-gray-700 text-sm">Tidak memihak pada kelompok apapun tanpa diskriminasi</p>
                </div>

                <!-- Profesional -->
                <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mx-auto mb-4">
                        <svg class="h-6 w-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Profesional</h3>
                    <p class="text-gray-700 text-sm">Bekerja dengan standar profesional yang tinggi</p>
                </div>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-lg shadow-lg p-8 text-white mb-12">
            <div class="flex items-center justify-center mb-6">
                <svg class="h-8 w-8 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                </svg>
                <h2 class="text-2xl font-bold">Pencapaian Kami</h2>
            </div>
            <p class="text-center mb-8 text-red-100">Dedikasi kami dalam melayani masyarakat</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-5xl font-bold mb-2">12+</div>
                    <p class="text-red-100">Tahun Berdiri</p>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">5000+</div>
                    <p class="text-red-100">Pendonor Terdaftar</p>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">100+</div>
                    <p class="text-red-100">Kegiatan Per Tahun</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection