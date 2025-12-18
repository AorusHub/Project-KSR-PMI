{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\kontak.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors">
    <!-- Header Section -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 transition-colors">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-12 text-center">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-3">Hubungi Kami</h1>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Kami siap membantu Anda. Jangan ragu untuk menghubungi kami</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
        <div class="grid md:grid-cols-2 gap-6 sm:gap-8">
            
            <!-- Contact Form -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-xl p-6 sm:p-8 transition-colors">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-6">Kirim Pesan</h2>

                {{-- ✅ FORM KIRIM KE WHATSAPP --}}
                <form id="contactForm" onsubmit="sendToWhatsApp(event)">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Nama Lengkap <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <input type="text" id="nama" name="nama" required
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400 focus:bg-white dark:focus:bg-gray-600 transition-all placeholder:text-gray-400 dark:placeholder:text-gray-500"
                            placeholder="Masukkan nama lengkap Anda">
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Email <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400 focus:bg-white dark:focus:bg-gray-600 transition-all placeholder:text-gray-400 dark:placeholder:text-gray-500"
                            placeholder="nama@email.com">
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Subjek <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <input type="text" id="subjek" name="subjek" required
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400 focus:bg-white dark:focus:bg-gray-600 transition-all placeholder:text-gray-400 dark:placeholder:text-gray-500"
                            placeholder="Subjek pesan Anda">
                    </div>

                    <div class="mb-4 sm:mb-6">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Pesan <span class="text-red-500 dark:text-red-400">*</span>
                        </label>
                        <textarea id="pesan" name="pesan" rows="5" required
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400 focus:bg-white dark:focus:bg-gray-600 transition-all resize-none placeholder:text-gray-400 dark:placeholder:text-gray-500"
                            placeholder="Tulis pesan Anda di sini..."></textarea>
                    </div>

                    <button type="submit" 
                        class="w-full px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base bg-red-600 dark:bg-red-700 text-white font-semibold rounded-lg hover:bg-red-700 dark:hover:bg-red-600 transition-all shadow-md hover:shadow-lg">
                        Kirim Pesan
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-xl p-6 sm:p-8 mb-6 transition-colors">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-6">Informasi Kontak</h2>
                    
                    <div class="space-y-4 sm:space-y-6">
                        <!-- Alamat -->
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white mb-1">Alamat</h3>
                                {{-- ✅ EDIT ALAMAT DI SINI --}}
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Jl. Perintis Kemerdekaan KM.10<br>Makassar, Sulawesi Selatan 90245</p>
                            </div>
                        </div>

                        <!-- Telepon -->
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white mb-1">Telepon</h3>
                                {{-- ✅ EDIT NOMOR TELEPON DI SINI --}}
                                <a href="tel:0411585610" class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors">(0411) 585610</a>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white mb-1">Email</h3>
                                {{-- ✅ EDIT EMAIL DI SINI --}}
                                <a href="mailto:ksr@pmiuhhas.or.id" class="text-xs sm:text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 break-all transition-colors">ksr@pmiuhhas.or.id</a>
                            </div>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white mb-1">Jam Operasional</h3>
                                {{-- ✅ EDIT JAM OPERASIONAL DI SINI --}}
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Senin - Jumat: 08:00 - 16:00 WITA<br>Sabtu: 08:00 - 12:00 WITA</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-xl p-6 sm:p-8 transition-colors">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4">Ikuti Kami</h3>
                    <div class="flex gap-2 sm:gap-3">
                        {{-- ✅ EDIT LINK FACEBOOK DI SINI --}}
                        <a href="https://www.facebook.com/profile.php?id=100066904159717" target="_blank" class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors" aria-label="Facebook">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        {{-- ✅ EDIT LINK INSTAGRAM DI SINI --}}
                        <a href="https://www.instagram.com/ksrpmi.unhas?igsh=OW95dWZsNzdqYXE0" target="_blank" class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors" aria-label="Instagram">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        {{-- ✅ EDIT LINK TWITTER/X DI SINI --}}
                        <a href="https://x.com/ksrpmiunhas" target="_blank" class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors" aria-label="Twitter">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map -->
        <div class="mt-8 sm:mt-12 bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-xl p-4 sm:p-6 transition-colors">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-6">Lokasi Kami</h2>
            <div class="rounded-lg overflow-hidden">
                {{-- ✅ EDIT EMBED MAP DI SINI --}}
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3973.805992755262!2d119.48704550000001!3d-5.134919699999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbefcca05a8f1c1%3A0xb03aa4596d1db7bf!2sUKM%20KSR%20PMI%20UNHAS!5e0!3m2!1sid!2sid!4v1765925024304!5m2!1sid!2sid" 
                width="100%" 
                height="350" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
            </div>
        </div>
    </div>
</div>

{{-- ✅ JAVASCRIPT KIRIM KE WHATSAPP --}}
// ...existing code...

{{-- ✅ JAVASCRIPT KIRIM KE WHATSAPP --}}
@push('scripts')
<script>
function sendToWhatsApp(event) {
    event.preventDefault();
    
    // Ambil data form
    const nama = document.getElementById('nama').value.trim();
    const email = document.getElementById('email').value.trim();
    const subjek = document.getElementById('subjek').value.trim();
    const pesan = document.getElementById('pesan').value.trim();
    
    // Validasi
    if (!nama || !email || !subjek || !pesan) {
        alert('Semua field harus diisi!');
        return;
    }
    
    // Format pesan untuk WhatsApp
    const message = `*PESAN KONTAK KSR PMI UNHAS*

📝 *Subjek:* ${subjek}

👤 *Nama:* ${nama}
📧 *Email:* ${email}

💬 *Pesan:*
${pesan}

---
_Dikirim melalui Website KSR PMI UNHAS_`;
    
    // Encode message untuk URL
    const encodedMessage = encodeURIComponent(message);
    
    // ✅ GANTI dengan NOMOR WHATSAPP (format: 62xxx tanpa + dan spasi)
    const phoneNumber = '628113998769'; // Contoh: 0811-3998-3769 → 6281139983769
    const whatsappURL = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
    
    // Buka WhatsApp
    window.open(whatsappURL, '_blank');
    
    // Reset form setelah submit
    document.getElementById('contactForm').reset();
}
</script>
@endpush
@endsection