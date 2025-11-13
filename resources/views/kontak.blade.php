{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\kontak.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white border-b">
        <div class="max-w-6xl mx-auto px-4 py-12 text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-3">Hubungi Kami</h1>
            <p class="text-gray-600">Kami siap membantu Anda. Jangan ragu untuk menghubungi kami</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid md:grid-cols-2 gap-8">
            
            <!-- Contact Form -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>

                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('kontak.send') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" required value="{{ old('nama') }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all"
                            placeholder="Masukkan nama lengkap Anda">
                        @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required value="{{ old('email') }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all"
                            placeholder="nama@email.com">
                        @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Subjek <span class="text-red-500">*</span></label>
                        <input type="text" name="subjek" required value="{{ old('subjek') }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all"
                            placeholder="Subjek pesan Anda">
                        @error('subjek')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pesan <span class="text-red-500">*</span></label>
                        <textarea name="pesan" rows="5" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all resize-none"
                            placeholder="Tulis pesan Anda di sini...">{{ old('pesan') }}</textarea>
                        @error('pesan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                        class="w-full px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-all shadow-md">
                        Kirim Pesan
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-8 mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Kontak</h2>
                    
                    <div class="space-y-6">
                        <!-- Alamat -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Alamat</h3>
                                <p class="text-gray-600">Jl. Perintis Kemerdekaan KM.10<br>Makassar, Sulawesi Selatan 90245</p>
                            </div>
                        </div>

                        <!-- Telepon -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Telepon</h3>
                                <p class="text-gray-600">(0411) 585610</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                                <a href="mailto:ksr@pmiuhhas.or.id" class="text-red-600 hover:text-red-700">ksr@pmiuhhas.or.id</a>
                            </div>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Jam Operasional</h3>
                                <p class="text-gray-600">Senin - Jumat: 08:00 - 16:00 WITA<br>Sabtu: 08:00 - 12:00 WITA</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h3 class="font-semibold text-gray-900 mb-4">Ikuti Kami</h3>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors">
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors">
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors">
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map -->
        <div class="mt-12 bg-white rounded-lg shadow-md p-4">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 px-4 pt-4">Lokasi Kami</h2>
            <div class="rounded-lg overflow-hidden">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3973.7562831652677!2d119.48827931476833!3d-5.135113596288074!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbee329d96c4671%3A0x3030bfbcaf770b0!2sUniversitas%20Hasanuddin!5e0!3m2!1sid!2sid!4v1234567890123!5m2!1sid!2sid"
                    width="100%" 
                    height="400" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    class="rounded-lg">
                </iframe>
            </div>
        </div>
    </div>
</div>
@endsection