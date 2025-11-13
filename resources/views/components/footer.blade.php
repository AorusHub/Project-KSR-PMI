{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\components\footer.blade.php --}}
<footer class="bg-gray-800 text-white mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            {{-- Kolom 1: Logo & Info --}}
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="Logo KSR PMI" class="h-14 w-14 object-contain" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2256%22 height=%2256%22 viewBox=%220 0 56 56%22%3E%3Ccircle cx=%2228%22 cy=%2228%22 r=%2228%22 fill=%22%23dc2626%22/%3E%3Cpath d=%22M28 12 L32 26 L46 26 L35 35 L39 49 L28 40 L17 49 L21 35 L10 26 L24 26 Z%22 fill=%22white%22/%3E%3C/svg%3E'">
                    <div>
                        <h3 class="font-bold text-lg">KSR PMI UNHAS</h3>
                        <p class="text-sm text-gray-400">Makassar</p>
                    </div>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Sistem Informasi Donor Darah KSR PMI Universitas Hasanuddin
                </p>
            </div>

            {{-- Kolom 2: Menu --}}
            <div>
                <h3 class="font-bold text-lg mb-4">Menu</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors text-sm">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/kegiatan') }}" class="text-gray-400 hover:text-white transition-colors text-sm">
                            Kegiatan Donor
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/tentang-kami') }}" class="text-gray-400 hover:text-white transition-colors text-sm">
                            Tentang Kami
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Kolom 3: Layanan --}}
            <div>
                <h3 class="font-bold text-lg mb-4">Layanan</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ url('/cek-kelayakan') }}" class="text-gray-400 hover:text-white transition-colors text-sm">
                            Cek Kelayakan Donor
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/permintaan-donor') }}" class="text-gray-400 hover:text-white transition-colors text-sm">
                            Formulir Permintaan Donor
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('info-utd')  }}" class="text-gray-400 hover:text-white transition-colors text-sm">
                            Informasi UTD/PMI
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Kolom 4: Kontak --}}
            <div>
                <h3 class="font-bold text-lg mb-4">Kontak</h3>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="flex items-start space-x-2">
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:ksr@pmi.unhas.ac.id" class="hover:text-white transition-colors">
                            Email: ksr@pmi.unhas.ac.id
                        </a>
                    </li>
                    <li class="flex items-start space-x-2">
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <a href="tel:04115586010" class="hover:text-white transition-colors">
                            Telp: (0411) 586010
                        </a>
                    </li>
                    <li class="flex items-start space-x-2">
                        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>
                            Alamat: Jl. Perintis Kemerdekaan KM.10, Makassar
                        </span>
                    </li>
                </ul>
            </div>

        </div>

        {{-- Copyright --}}
        <div class="border-t border-gray-700 mt-8 pt-8 text-center">
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} KSR PMI UNHAS Makassar. All rights reserved.
            </p>
        </div>
    </div>
</footer>