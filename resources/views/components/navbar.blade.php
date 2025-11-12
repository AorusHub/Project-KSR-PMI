{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\components\navbar.blade.php --}}
<nav class="bg-white shadow-md border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo & Brand --}}
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="Logo KSR PMI" class="h-12 w-12 object-contain" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2248%22 height=%2248%22 viewBox=%220 0 48 48%22%3E%3Ccircle cx=%2224%22 cy=%2224%22 r=%2224%22 fill=%22%23dc2626%22/%3E%3Cpath d=%22M24 10 L28 22 L40 22 L30 30 L34 42 L24 34 L14 42 L18 30 L8 22 L20 22 Z%22 fill=%22white%22/%3E%3C/svg%3E'">
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-gray-800">KSR PMI UNHAS</span>
                        <span class="text-xs text-gray-600">Korps Sukarela</span>
                    </div>
                </a>
            </div>

            {{-- Navigation Links --}}
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors {{ request()->routeIs('home') ? 'text-red-600' : '' }}">
                    Beranda
                </a>
                <a href="{{ url('/kegiatan') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors">
                    Kegiatan Donor
                </a>
                <a href="{{ url('/tentang-kami') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors">
                    Tentang Kami
                </a>
                <a href="{{ url('/kontak') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors">
                    Kontak
                </a>
                <a href="{{ url('/faq') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors">
                    FAQ
                </a>
            </div>

            {{-- Right Side: Auth Buttons or User Menu --}}
            <div class="flex items-center space-x-4">
                @auth
                    @php
                        $user = Auth::user();
                        $dashboardRoute = route('pendonor.dashboard'); // default
                        
                        if ($user->isAdmin()) {
                            $dashboardRoute = route('admin.dashboard');
                        } elseif ($user->isStaf()) {
                            $dashboardRoute = route('staf.dashboard');
                        }
                        
                        // Hitung notifikasi (dummy data, nanti bisa diganti dari database)
                        $notificationCount = 3; // Contoh: 3 notifikasi belum dibaca
                    @endphp
                    
                    {{-- Notification Bell --}}
                    <div class="relative" x-data="{ notifOpen: false }">
                        <button @click="notifOpen = !notifOpen" class="relative p-2 text-gray-600 hover:text-red-600 hover:bg-gray-100 rounded-full transition-colors focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if($notificationCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                                {{ $notificationCount }}
                            </span>
                            @endif
                        </button>

                        {{-- Notification Dropdown --}}
                        <div x-show="notifOpen" 
                             @click.away="notifOpen = false"
                             x-transition
                             class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl py-2 z-50 border border-gray-200 max-h-96 overflow-y-auto"
                             style="display: none;">
                            
                            <div class="px-4 py-3 border-b border-gray-200">
                                <h3 class="text-sm font-bold text-gray-800">Notifikasi</h3>
                            </div>

                            {{-- Notification Items (Contoh) --}}
                            <div class="divide-y divide-gray-100">
                                <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900">Kegiatan Donor Baru</p>
                                            <p class="text-xs text-gray-500 mt-1">Ada kegiatan donor di Kampus UNHAS</p>
                                            <p class="text-xs text-gray-400 mt-1">2 jam yang lalu</p>
                                        </div>
                                        <span class="flex-shrink-0 w-2 h-2 bg-red-500 rounded-full"></span>
                                    </div>
                                </a>

                                <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900">Donasi Berhasil</p>
                                            <p class="text-xs text-gray-500 mt-1">Terima kasih atas donasi Anda!</p>
                                            <p class="text-xs text-gray-400 mt-1">1 hari yang lalu</p>
                                        </div>
                                    </div>
                                </a>

                                <a href="#" class="block px-4 py-3 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900">Pengingat</p>
                                            <p class="text-xs text-gray-500 mt-1">Anda sudah bisa donor kembali</p>
                                            <p class="text-xs text-gray-400 mt-1">3 hari yang lalu</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="px-4 py-3 border-t border-gray-200 text-center">
                                <a href="{{ url('/notifications') }}" class="text-sm text-red-600 hover:text-red-700 font-medium">
                                    Lihat Semua Notifikasi
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Dashboard Button --}}
                    <a href="{{ $dashboardRoute }}" class="hidden md:flex items-center px-6 py-2 bg-white border-white text-gray-800 font-semibold rounded-lg hover:border-red-600 hover:text-red-600 transition-all">
                        Dashboard
                    </a>

                    {{-- User Dropdown --}}
                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($user->nama, 0, 1)) }}
                            </div>
                            <span class="hidden md:block text-gray-700 font-medium">{{ $user->nama }}</span>
                            <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="dropdownOpen" 
                             @click.away="dropdownOpen = false"
                             x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-200"
                             style="display: none;">
                            
                            <div class="px-4 py-2 border-b border-gray-200">
                                <p class="text-sm font-semibold text-gray-800">{{ $user->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                <p class="text-xs text-red-600 font-medium mt-1 capitalize">{{ $user->role }}</p>
                            </div>

                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>Profil Saya</span>
                                </div>
                            </a>

                            @if($user->isPendonor())
                            <a href="{{ route('pendonor.riwayat-donor') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span>Riwayat Donasi</span>
                                </div>
                            </a>
                            @endif

                            <div class="border-t border-gray-200 my-2"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        <span>Keluar</span>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    {{-- Guest: Login & Register Buttons --}}
                    <a href="{{ route('login') }}" class="px-6 py-2 text-gray-700 font-semibold hover:text-red-600 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors shadow-md">
                        Daftar Sekarang
                    </a>
                @endauth
            </div>

            {{-- Mobile Menu Button --}}
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-red-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" 
         x-transition 
         class="md:hidden bg-white border-t border-gray-200"
         x-data="{ mobileMenuOpen: false }"
         @click.away="mobileMenuOpen = false"
         style="display: none;">
        <div class="px-4 py-3 space-y-3">
            <a href="{{ route('home') }}" class="block text-gray-700 hover:text-red-600 font-medium">Beranda</a>
            <a href="{{ url('/kegiatan') }}" class="block text-gray-700 hover:text-red-600 font-medium">Kegiatan Donor</a>
            <a href="{{ url('/tentang-kami') }}" class="block text-gray-700 hover:text-red-600 font-medium">Tentang Kami</a>
            <a href="{{ url('/kontak') }}" class="block text-gray-700 hover:text-red-600 font-medium">Kontak</a>
            <a href="{{ url('/faq') }}" class="block text-gray-700 hover:text-red-600 font-medium">FAQ</a>
            
            @auth
                @php
                    $user = Auth::user();
                    $dashboardRoute = route('pendonor.dashboard');
                    if ($user->isAdmin()) {
                        $dashboardRoute = route('admin.dashboard');
                    } elseif ($user->isStaf()) {
                        $dashboardRoute = route('staf.dashboard');
                    }
                @endphp
                
                {{-- Mobile: User Menu --}}
                <div class="pt-3 border-t border-gray-200 space-y-2">
                    <div class="px-3 py-2 bg-gray-50 rounded-lg">
                        <p class="text-sm font-semibold text-gray-800">{{ $user->nama }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                        <p class="text-xs text-red-600 font-medium mt-1 capitalize">{{ $user->role }}</p>
                    </div>
                    
                    {{-- Notifikasi Mobile --}}
                    <a href="{{ url('/notifications') }}" class="flex items-center justify-between px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">
                        <span>Notifikasi</span>
                        @if($notificationCount > 0)
                        <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                            {{ $notificationCount }}
                        </span>
                        @endif
                    </a>
                    
                    <a href="{{ $dashboardRoute }}" class="block px-3 py-2 bg-red-600 text-white text-center hover:bg-red-700 rounded-lg font-medium">
                        Dashboard
                    </a>
                    
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">
                        Profil Saya
                    </a>
                    
                    @if($user->isPendonor())
                    <a href="{{ route('pendonor.riwayat-donor') }}" class="block px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">
                        Riwayat Donasi
                    </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg font-medium">
                            Keluar
                        </button>
                    </form>
                </div>
            @else
                {{-- Mobile: Login & Register --}}
                <div class="pt-3 border-t border-gray-200 space-y-2">
                    <a href="{{ route('login') }}" class="block text-center py-2 text-gray-700 font-semibold hover:text-red-600">Masuk</a>
                    <a href="{{ route('register') }}" class="block text-center py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700">Daftar Sekarang</a>
                </div>
            @endauth
        </div>
    </div>
</nav>

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
@endpush