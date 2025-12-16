{{-- filepath: resources/views/components/navbar.blade.php --}}

{{-- ✅ LOAD ALPINE.JS DI HEAD (SEBELUM NAVBAR) --}}
@once
@push('styles')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
@endonce

<nav class="bg-white dark:bg-gray-800 shadow-md border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 transition-colors" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo & Brand --}}
            <div class="flex items-center space-x-2 sm:space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 sm:space-x-3">
                    <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="Logo KSR PMI" class="h-10 w-10 sm:h-12 sm:w-12 object-contain" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2248%22 height=%2248%22 viewBox=%220 0 48 48%22%3E%3Ccircle cx=%2224%22 cy=%2224%22 r=%2224%22 fill=%22%23dc2626%22/%3E%3Cpath d=%22M24 10 L28 22 L40 22 L30 30 L34 42 L24 34 L14 42 L18 30 L8 22 L20 22 Z%22 fill=%22white%22/%3E%3C/svg%3E'">
                    <div class="flex flex-col">
                        <span class="text-xs sm:text-sm font-bold text-gray-800 dark:text-white">KSR PMI UNHAS</span>
                        <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 hidden sm:block">Korps Sukarela</span>
                    </div>
                </a>
            </div>

            {{-- Navigation Links (Desktop) --}}
            <div class="hidden lg:flex items-center space-x-6 xl:space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 font-medium transition-colors text-sm xl:text-base {{ request()->routeIs('home') ? 'text-red-600 dark:text-red-400' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('kegiatan.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 font-medium transition-colors text-sm xl:text-base {{ request()->routeIs('kegiatan.*') ? 'text-red-600 dark:text-red-400' : '' }}">
                    Kegiatan Donor
                </a>
                <a href="{{ route('tentang-kami') }}" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 font-medium transition-colors text-sm xl:text-base {{ request()->routeIs('tentang-kami') ? 'text-red-600 dark:text-red-400' : '' }}">
                    Tentang Kami
                </a>
                <a href="{{ route('kontak') }}" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 font-medium transition-colors text-sm xl:text-base {{ request()->routeIs('kontak') ? 'text-red-600 dark:text-red-400' : '' }}">
                    Kontak
                </a>
                <a href="{{ route('faq') }}" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 font-medium transition-colors text-sm xl:text-base {{ request()->routeIs('faq') ? 'text-red-600 dark:text-red-400' : '' }}">
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
                        <button @click="toggleNotif()" class="relative p-1.5 sm:p-2 text-gray-600 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors focus:outline-none">
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
                             class="absolute right-0 mt-2 w-[90vw] sm:w-80 bg-white dark:bg-gray-800 rounded-lg shadow-xl py-2 z-50 border border-gray-200 dark:border-gray-700 max-h-[80vh] sm:max-h-96 overflow-y-auto">
                            
                            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                                <h3 class="text-sm font-bold text-gray-800 dark:text-white">Notifikasi</h3>
                                <button @click="markAllRead()" x-show="unreadCount > 0" class="text-xs text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-500 font-medium">
                                    Tandai semua dibaca
                                </button>
                            </div>

                            {{-- Notification Items --}}
                            <div x-show="!loading" class="divide-y divide-gray-100 dark:divide-gray-700">
                                <template x-if="notifications.length === 0">
                                    <div class="px-4 py-8 text-center">
                                        <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                        </svg>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada notifikasi</p>
                                    </div>
                                </template>

                                <template x-for="notif in notifications" :key="notif.id">
                                    <a :href="notif.url" 
                                    @click="markAsRead(notif.id)"
                                    class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" 
                                    :class="notif.dibaca ? 'bg-white dark:bg-gray-800' : 'bg-blue-50 dark:bg-blue-900/20'">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center"
                                                    :class="{
                                                        'bg-blue-100 dark:bg-blue-900/30': notif.icon_type === 'blue',
                                                        'bg-green-100 dark:bg-green-900/30': notif.icon_type === 'green',
                                                        'bg-yellow-100 dark:bg-yellow-900/30': notif.icon_type === 'yellow',
                                                        'bg-red-100 dark:bg-red-900/30': notif.icon_type === 'red'
                                                    }">
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" 
                                                        :class="{
                                                            'text-blue-600 dark:text-blue-400': notif.icon_type === 'blue',
                                                            'text-green-600 dark:text-green-400': notif.icon_type === 'green',
                                                            'text-yellow-600 dark:text-yellow-400': notif.icon_type === 'yellow',
                                                            'text-red-600 dark:text-red-400': notif.icon_type === 'red'
                                                        }"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white" x-text="notif.jenis"></p>
                                                <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400 mt-1" x-text="notif.isi"></p>
                                                <p class="text-[10px] sm:text-xs text-gray-400 dark:text-gray-500 mt-1" x-text="notif.waktu"></p>
                                                
                                                {{-- ✅ TOMBOL TANDAI SUDAH DIBACA --}}
                                                <button x-show="!notif.dibaca"
                                                        @click.stop.prevent="markAsRead(notif.id)"
                                                        class="mt-2 text-[10px] sm:text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium hover:underline transition-colors">
                                                    ✓ Tandai sudah dibaca
                                                </button>
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
                                 ? 'bg-red-600 dark:bg-red-700 text-white shadow-md border-red-600 dark:border-red-700' 
                                 : 'bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 hover:border-red-600 dark:hover:border-red-500 hover:text-red-600 dark:hover:text-red-400' }}">
                        Dashboard
                    </a>

                    {{-- User Dropdown --}}
                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-1 sm:space-x-2 focus:outline-none">
                            <div class="w-8 h-8 sm:w-9 sm:h-9 bg-red-600 dark:bg-red-700 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($user->nama, 0, 1)) }}
                            </div>
                            <span class="hidden md:block text-gray-700 dark:text-gray-200 font-medium text-sm lg:text-base max-w-[120px] truncate">{{ $user->nama }}</span>
                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': dropdownOpen }" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="dropdownOpen" 
                             @click.away="dropdownOpen = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 sm:w-64 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2 z-50 border border-gray-200 dark:border-gray-700">
                            
                            <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">{{ $user->nama }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</p>
                                <p class="text-xs text-red-600 dark:text-red-400 font-medium mt-1 capitalize">{{ $user->role }}</p>
                            </div>

                            {{-- Dashboard (Mobile Only) --}}
                            <a href="{{ $dashboardRoute }}" class="sm:hidden block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <span>Dashboard</span>
                                </div>
                            </a>

                            {{-- MENU KHUSUS PENDONOR --}}
                            @if($user->isPendonor())
                                <a href="{{ route('pendonor.profil') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span>Profil Saya</span>
                                    </div>
                                </a>
                                
                                <a href="{{ route('pendonor.riwayat-donor') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span>Riwayat Donasi</span>
                                    </div>
                                </a>

                                <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
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
                    {{-- ✅ GUEST: Desktop Login & Register --}}
                    <a href="{{ route('login') }}" class="hidden lg:inline-block px-3 sm:px-6 py-1.5 sm:py-2 text-gray-700 dark:text-gray-300 font-semibold hover:text-red-600 dark:hover:text-red-400 transition-colors text-xs sm:text-sm">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="hidden lg:inline-block px-3 sm:px-6 py-1.5 sm:py-2 bg-red-600 dark:bg-red-700 text-white font-semibold rounded-lg hover:bg-red-700 dark:hover:bg-red-800 transition-colors shadow-md text-xs sm:text-sm whitespace-nowrap">
                        Daftar
                    </a>
                @endauth

                {{-- ✅ Mobile Menu Button (Satu Tombol Toggle) --}}
                <div class="lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 focus:outline-none p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg class="h-6 w-6 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Mobile Menu (Default HIDDEN) --}}
    <div x-show="mobileMenuOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         @click.away="mobileMenuOpen = false"
         class="lg:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-lg transition-colors">
        <div class="px-4 py-3 space-y-1 max-h-[calc(100vh-4rem)] overflow-y-auto">
            {{-- Navigation Links --}}
            <a href="{{ route('home') }}" class="block text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium py-3 px-3 rounded-lg transition-colors {{ request()->routeIs('home') ? 'text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20' : '' }}">
                Beranda
            </a>
            <a href="{{ route('kegiatan.index') }}" class="block text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium py-3 px-3 rounded-lg transition-colors {{ request()->routeIs('kegiatan.*') ? 'text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20' : '' }}">
                Kegiatan Donor
            </a>
            <a href="{{ route('tentang-kami') }}" class="block text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium py-3 px-3 rounded-lg transition-colors {{ request()->routeIs('tentang-kami') ? 'text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20' : '' }}">
                Tentang Kami
            </a>
            <a href="{{ route('kontak') }}" class="block text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium py-3 px-3 rounded-lg transition-colors {{ request()->routeIs('kontak') ? 'text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20' : '' }}">
                Kontak
            </a>
            <a href="{{ route('faq') }}" class="block text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium py-3 px-3 rounded-lg transition-colors {{ request()->routeIs('faq') ? 'text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20' : '' }}">
                FAQ
            </a>
            
            @guest
                {{-- ✅ Mobile: Login & Register di Bawah --}}
                <div class="pt-3 mt-3 border-t border-gray-200 dark:border-gray-700 space-y-2">
                    <a href="{{ route('login') }}" class="block text-center py-3 text-gray-700 dark:text-gray-300 font-semibold hover:text-red-600 dark:hover:text-red-400 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="block text-center py-3 bg-red-600 dark:bg-red-700 text-white font-semibold rounded-lg hover:bg-red-700 dark:hover:bg-red-800 transition-colors shadow-md">
                        Daftar Sekarang
                    </a>
                </div>
            @endguest
        </div>
    </div>
</nav>

{{-- ✅ ADD ALPINE.JS CLOAKING STYLE --}}
@once
@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush
@endonce

{{-- ✅ JAVASCRIPT POLLING UNTUK NOTIFIKASI REAL-TIME --}}
@auth
@push('scripts')
<script>
function notificationSystem() {
    return {
        notifOpen: false,
        loading: false,
        notifications: [],
        unreadCount: 0,
        
        init() {
            this.fetchNotifications();
            this.fetchUnreadCount();
            
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
            }
        },
        
        async fetchNotifications() {
            try {
                const response = await fetch('/api/notifications/latest');
                const data = await response.json();
                this.notifications = data;
            } catch (error) {
                console.error('Error fetching notifications:', error);
            }
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
                
                const notif = this.notifications.find(n => n.id === id);
                if (notif) {
                    notif.dibaca = true;
                }
                
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
                
                this.notifications.forEach(notif => {
                    notif.dibaca = true;
                });
                
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