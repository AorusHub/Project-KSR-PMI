{{-- filepath: resources/views/components/navbar.blade.php --}}
<nav class="bg-white shadow-md border-b border-gray-200 sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo & Brand --}}
            <div class="flex items-center space-x-2 sm:space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 sm:space-x-3">
                    <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="Logo KSR PMI" class="h-10 w-10 sm:h-12 sm:w-12 object-contain" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2248%22 height=%2248%22 viewBox=%220 0 48 48%22%3E%3Ccircle cx=%2224%22 cy=%2224%22 r=%2224%22 fill=%22%23dc2626%22/%3E%3Cpath d=%22M24 10 L28 22 L40 22 L30 30 L34 42 L24 34 L14 42 L18 30 L8 22 L20 22 Z%22 fill=%22white%22/%3E%3C/svg%3E'">
                    <div class="flex flex-col">
                        <span class="text-xs sm:text-sm font-bold text-gray-800">KSR PMI UNHAS</span>
                        <span class="text-[10px] sm:text-xs text-gray-600 hidden sm:block">Korps Sukarela</span>
                    </div>
                </a>
            </div>

            {{-- Navigation Links (Desktop) --}}
            <div class="hidden lg:flex items-center space-x-6 xl:space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm xl:text-base {{ request()->routeIs('home') ? 'text-red-600' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('kegiatan.index') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm xl:text-base {{ request()->routeIs('kegiatan.*') ? 'text-red-600' : '' }}">
                    Kegiatan Donor
                </a>
                <a href="{{ route('tentang-kami') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm xl:text-base {{ request()->routeIs('tentang-kami') ? 'text-red-600' : '' }}">
                    Tentang Kami
                </a>
                <a href="{{ route('kontak') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm xl:text-base {{ request()->routeIs('kontak') ? 'text-red-600' : '' }}">
                    Kontak
                </a>
                <a href="{{ route('faq') }}" class="text-gray-700 hover:text-red-600 font-medium transition-colors text-sm xl:text-base {{ request()->routeIs('faq') ? 'text-red-600' : '' }}">
                    FAQ
                </a>
            </div>

            {{-- Right Side: Auth Buttons or User Menu --}}
            <div class="flex items-center space-x-1 sm:space-x-3">
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
                    
                    {{-- ✅ NOTIFICATION BELL DENGAN REAL-TIME POLLING --}}
                    <div class="relative" x-data="notificationSystem()">
                        <button @click="toggleNotif()" class="relative p-1.5 sm:p-2 text-gray-600 hover:text-red-600 hover:bg-gray-100 rounded-full transition-colors focus:outline-none">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span x-show="unreadCount > 0" 
                                  x-text="unreadCount" 
                                  class="absolute -top-1 -right-1 sm:top-0 sm:right-0 inline-flex items-center justify-center px-1.5 py-0.5 sm:px-2 sm:py-1 text-[10px] sm:text-xs font-bold leading-none text-white transform sm:translate-x-1/2 sm:-translate-y-1/2 bg-red-600 rounded-full">
                            </span>
                        </button>

                        {{-- Notification Dropdown --}}
                        <div x-show="notifOpen" 
                             @click.away="notifOpen = false"
                             x-transition
                             class="absolute right-0 mt-2 w-[90vw] sm:w-80 bg-white rounded-lg shadow-xl py-2 z-50 border border-gray-200 max-h-[80vh] sm:max-h-96 overflow-y-auto"
                             style="display: none;">
                            
                            <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                                <h3 class="text-sm font-bold text-gray-800">Notifikasi</h3>
                                <button @click="markAllRead()" x-show="unreadCount > 0" class="text-xs text-red-600 hover:text-red-700 font-medium">
                                    Tandai semua dibaca
                                </button>
                            </div>

                            {{-- Loading State --}}
                            {{-- <div x-show="loading" class="px-4 py-8 text-center">
                                <svg class="animate-spin h-8 w-8 text-red-600 mx-auto" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="text-sm text-gray-500 mt-2">Memuat...</p>
                            </div> --}}

                            {{-- Notification Items --}}
                            <div x-show="!loading" class="divide-y divide-gray-100">
                                <template x-if="notifications.length === 0">
                                    <div class="px-4 py-8 text-center">
                                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                        </svg>
                                        <p class="text-sm text-gray-500">Tidak ada notifikasi</p>
                                    </div>
                                </template>

                                <template x-for="notif in notifications" :key="notif.id">
                                    <a @click="markAsRead(notif.id)" :href="notif.url" class="block px-4 py-3 hover:bg-gray-50 transition-colors">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center"
                                                    :class="{
                                                        'bg-blue-100': notif.icon_type === 'blue',
                                                        'bg-green-100': notif.icon_type === 'green',
                                                        'bg-yellow-100': notif.icon_type === 'yellow',
                                                        'bg-red-100': notif.icon_type === 'red'
                                                    }">
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" 
                                                        :class="{
                                                            'text-blue-600': notif.icon_type === 'blue',
                                                            'text-green-600': notif.icon_type === 'green',
                                                            'text-yellow-600': notif.icon_type === 'yellow',
                                                            'text-red-600': notif.icon_type === 'red'
                                                        }"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs sm:text-sm font-medium text-gray-900" x-text="notif.jenis"></p>
                                                <p class="text-[10px] sm:text-xs text-gray-500 mt-1" x-text="notif.isi"></p>
                                                <p class="text-[10px] sm:text-xs text-gray-400 mt-1" x-text="notif.waktu"></p>
                                            </div>
                                            <span x-show="!notif.dibaca" class="flex-shrink-0 w-2 h-2 bg-red-500 rounded-full"></span>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- Dashboard Button --}}
                    @php
                        $isDashboardActive = false;
                        if ($user->isPendonor() && request()->routeIs('pendonor.*')) {
                            $isDashboardActive = true;
                        } elseif ($user->isAdmin() && request()->routeIs('admin.*')) {
                            $isDashboardActive = true;
                        } elseif ($user->isStaf() && request()->routeIs('staf.*')) {
                            $isDashboardActive = true;
                        }
                    @endphp
                    <a href="{{ $dashboardRoute }}" 
                       class="hidden sm:inline-flex items-center px-4 lg:px-5 py-2 font-semibold rounded-lg transition-all text-xs lg:text-sm
                              {{ $isDashboardActive 
                                 ? 'bg-red-600 text-white shadow-md border-red-600' 
                                 : 'bg-white border border-gray-300 text-gray-800 hover:border-red-600 hover:text-red-600' }}">
                        Dashboard
                    </a>

                    {{-- User Dropdown --}}
                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-1 sm:space-x-2 focus:outline-none">
                            <div class="w-8 h-8 sm:w-9 sm:h-9 bg-red-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($user->nama, 0, 1)) }}
                            </div>
                            <span class="hidden md:block text-gray-700 font-medium text-sm lg:text-base max-w-[120px] truncate">{{ $user->nama }}</span>
                            <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="dropdownOpen" 
                             @click.away="dropdownOpen = false"
                             x-transition
                             class="absolute right-0 mt-2 w-56 sm:w-64 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-200"
                             style="display: none;">
                            
                            <div class="px-4 py-2 border-b border-gray-200">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $user->nama }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                                <p class="text-xs text-red-600 font-medium mt-1 capitalize">{{ $user->role }}</p>
                            </div>

                            {{-- Dashboard (Mobile Only) --}}
                            <a href="{{ $dashboardRoute }}" class="sm:hidden block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <span>Dashboard</span>
                                </div>
                            </a>

                            {{-- MENU KHUSUS PENDONOR --}}
                            @if($user->isPendonor())
                                <a href="{{ route('pendonor.profil') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span>Profil Saya</span>
                                    </div>
                                </a>
                                
                                <a href="{{ route('pendonor.riwayat-donor') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span>Riwayat Donasi</span>
                                    </div>
                                </a>

                                <div class="border-t border-gray-200 my-2"></div>
                            @endif

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
                    <a href="{{ route('login') }}" class="px-3 sm:px-6 py-1.5 sm:py-2 text-gray-700 font-semibold hover:text-red-600 transition-colors text-xs sm:text-sm">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-3 sm:px-6 py-1.5 sm:py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors shadow-md text-xs sm:text-sm whitespace-nowrap">
                        Daftar
                    </a>
                @endauth

                {{-- Mobile Menu Button --}}
                <div class="lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 hover:text-red-600 focus:outline-none p-1">
                        <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         @click.away="mobileMenuOpen = false"
         class="lg:hidden bg-white border-t border-gray-200 shadow-lg"
         style="display: none;">
        <div class="px-4 py-3 space-y-3 max-h-[calc(100vh-4rem)] overflow-y-auto">
            <a href="{{ route('home') }}" class="block text-gray-700 hover:text-red-600 font-medium py-2 {{ request()->routeIs('home') ? 'text-red-600' : '' }}">Beranda</a>
            <a href="{{ route('kegiatan.index') }}" class="block text-gray-700 hover:text-red-600 font-medium py-2 {{ request()->routeIs('kegiatan.*') ? 'text-red-600' : '' }}">Kegiatan Donor</a>
            <a href="{{ route('tentang-kami') }}" class="block text-gray-700 hover:text-red-600 font-medium py-2 {{ request()->routeIs('tentang-kami') ? 'text-red-600' : '' }}">Tentang Kami</a>
            <a href="{{ route('kontak') }}" class="block text-gray-700 hover:text-red-600 font-medium py-2 {{ request()->routeIs('kontak') ? 'text-red-600' : '' }}">Kontak</a>
            <a href="{{ route('faq') }}" class="block text-gray-700 hover:text-red-600 font-medium py-2 {{ request()->routeIs('faq') ? 'text-red-600' : '' }}">FAQ</a>
            
            @guest
                {{-- Mobile: Login & Register --}}
                <div class="pt-3 border-t border-gray-200 space-y-2">
                    <a href="{{ route('login') }}" class="block text-center py-2 text-gray-700 font-semibold hover:text-red-600 border border-gray-300 rounded-lg">Masuk</a>
                    <a href="{{ route('register') }}" class="block text-center py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700">Daftar Sekarang</a>
                </div>
            @endguest
        </div>
    </div>
</nav>

{{-- ✅ JAVASCRIPT POLLING UNTUK NOTIFIKASI REAL-TIME --}}
@auth
@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
<script>
function notificationSystem() {
    return {
        notifOpen: false,
        loading: false,
        notifications: [],
        unreadCount: 0,
        
        init() {
            // Muat notifikasi pertama kali
            this.fetchNotifications();
            this.fetchUnreadCount();
            
            // Polling setiap 10 detik (10000 ms)
            setInterval(() => {
                this.fetchUnreadCount();
                if (this.notifOpen) {
                    this.fetchNotifications();
                }
            }, 10000);
        },
        
        toggleNotif() {
            this.notifOpen = !this.notifOpen;
            if (this.notifOpen) {
                this.fetchNotifications();
                // ✅ Tandai semua sebagai dibaca saat buka dropdown
                setTimeout(() => {
                    this.markAllRead();
                }, 500);
            }
        },
        
       async fetchNotifications() {
            // ✅ TIDAK ADA loading = true lagi
            try {
                const response = await fetch('/api/notifications/latest');
                const data = await response.json();
                this.notifications = data;
            } catch (error) {
                console.error('Error fetching notifications:', error);
            }
            // ✅ TIDAK ADA finally loading = false
        },
        
        async fetchUnreadCount() {
            try {
                const response = await fetch('/api/notifications/unread-count');
                const data = await response.json();
                this.unreadCount = data.count;
            } catch (error) {
                console.error('Error fetching unread count:', error);
            }
        },
        
        async markAsRead(id) {
            try {
                await fetch(`/api/notifications/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                });
                this.fetchNotifications();
                this.fetchUnreadCount();
            } catch (error) {
                console.error('Error marking as read:', error);
            }
        },
        
        async markAllRead() {
            try {
                await fetch('/api/notifications/read-all', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                });
                this.fetchNotifications();
                this.fetchUnreadCount();
            } catch (error) {
                console.error('Error marking all as read:', error);
            }
        }
    }
}
</script>
@endpush
@endauth