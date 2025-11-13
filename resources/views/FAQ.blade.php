{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\FAQ.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white border-b">
        <div class="max-w-6xl mx-auto px-4 py-12 text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-3">Pertanyaan yang Sering Diajukan</h1>
            <p class="text-gray-600">Temukan jawaban atas pertanyaan umum seputar donor darah</p>
        </div>
    </div>

    <!-- FAQ Content -->
    <div class="max-w-4xl mx-auto px-4 py-12">
        
        <!-- Umum Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-red-600">Umum</h2>
            
            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Apa itu donor darah?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <p>Donor darah adalah proses pengambilan darah dari seseorang yang sehat untuk digunakan bagi pasien yang membutuhkan. Darah yang didonorkan dapat menyelamatkan nyawa banyak orang.</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Mengapa donor darah itu penting?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <p>Donor darah sangat penting karena dapat menyelamatkan nyawa pasien yang mengalami kehilangan darah akibat kecelakaan, operasi, atau penyakit tertentu. Setiap unit darah yang didonorkan dapat membantu hingga tiga orang.</p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Berapa lama proses donor darah?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <p>Proses donor darah biasanya berlangsung 30-45 menit, mulai dari pemeriksaan kesehatan hingga pengambilan darah. Seseorang dapat mendonorkan darah setiap 3-4 bulan.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Persyaratan Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-red-600">Persyaratan</h2>
            
            <div class="space-y-4">
                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Siapa saja yang bisa menjadi donor darah?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <p>Persyaratan menjadi donor darah:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>Berusia 17-60 tahun</li>
                            <li>Berat badan minimal 50 kg</li>
                            <li>Tekanan darah normal</li>
                            <li>Kadar hemoglobin cukup</li>
                            <li>Dalam kondisi kesehatan baik</li>
                        </ul>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Berapa berat darah yang diambil?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <p>Biasanya 450 ml darah diambil untuk satu kali donor. Jumlah ini aman dan tubuh dapat dengan cepat mengganti darah yang hilang.</p>
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Apakah ada batasan usia maksimal untuk donor?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <p>Ya, batasan usia maksimal adalah 60 tahun. Namun untuk donor pertama harus berusia minimal 17 tahun.</p>
                    </div>
                </div>

                <!-- FAQ Item 7 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Apakah saya bisa donor setelah vaksinasi COVID-19?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <p>Ya, Anda dapat mendonor darah setelah vaksinasi COVID-19. Tidak ada penundaan waktu yang diperlukan jika Anda merasa sehat.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Proses Donor Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-red-600">Proses Donor</h2>
            
            <div class="space-y-4">
                <!-- FAQ Item 8 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Apa yang harus saya persiapkan sebelum donor?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Tidur cukup malam sebelumnya</li>
                            <li>Makan dan minum dengan baik</li>
                            <li>Hindari minuman beralkohol 24 jam sebelumnya</li>
                            <li>Bawa kartu identitas</li>
                        </ul>
                    </div>
                </div>

                <!-- FAQ Item 9 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Apakah donor darah itu aman?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <p>Ya, donor darah sangat aman. Semua peralatan steril dan digunakan sekali pakai. Tidak ada risiko tertular penyakit.</p>
                    </div>
                </div>

                <!-- FAQ Item 10 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Berapa lama darah disimpan?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <p>Darah yang didonorkan akan disimpan dan diperiksa. Darah merah dapat disimpan selama 35 hari, sedangkan plasma dapat disimpan hingga 1 tahun.</p>
                    </div>
                </div>

                <!-- FAQ Item 11 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Apa yang harus dilakukan setelah donor?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Istirahat selama 15-20 menit</li>
                            <li>Minum dan makan makanan bergizi</li>
                            <li>Hindari aktivitas berat selama 24 jam</li>
                            <li>Tetap terhidrasi dengan minum banyak air</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keamanan Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-red-600">Keamanan</h2>
            
            <div class="space-y-4">
                <!-- FAQ Item 12 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Apakah donor darah aman?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <p>Ya, donor darah sangat aman. Semua prosedur dilakukan sesuai standar kesehatan internasional dengan peralatan steril.</p>
                    </div>
                </div>

                <!-- FAQ Item 13 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Apakah saya bisa tertular penyakit dari donor?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <p>Tidak. Semua darah donor diperiksa dengan ketat untuk berbagai penyakit menular sebelum digunakan. Risiko penularan sangat minimal.</p>
                    </div>
                </div>

                <!-- FAQ Item 14 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Bagaimana data saya dilindungi?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <p>Data pribadi donor dijaga dengan ketat sesuai standar kerahasiaan medis dan peraturan perlindungan data pribadi.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sistem Section -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-red-600">Sistem</h2>
            
            <div class="space-y-4">
                <!-- FAQ Item 15 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Bagaimana cara memastikan keaslian donor?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <p>Semua donor didaftarkan dalam sistem database kami dan terverifikasi. Setiap donor mendapat kartu identitas donor yang unik.</p>
                    </div>
                </div>

                <!-- FAQ Item 16 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Apakah saya bisa melihat riwayat donor?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <p>Ya, Anda dapat melihat riwayat donor Anda melalui dashboard pribadi atau menghubungi kami langsung.</p>
                    </div>
                </div>

                <!-- FAQ Item 17 -->
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                    <button class="w-full px-6 py-4 text-left font-semibold text-gray-900 flex items-center justify-between faq-toggle" onclick="toggleFaq(this)">
                        <span>Bagaimana cara membatalkan donor yang dijadwalkan?</span>
                        <svg class="h-5 w-5 text-gray-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-4 pt-4 text-gray-700">
                        <p>Anda dapat membatalkan jadwal donor melalui dashboard atau menghubungi kami minimal 24 jam sebelum jadwal donor.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Masih Ada Pertanyaan Section -->
        <div class="bg-red-50 rounded-lg p-8 text-center border border-red-100">
            <h3 class="text-xl font-bold text-gray-900 mb-2">Masih Ada Pertanyaan?</h3>
            <p class="text-gray-600 mb-4">Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan lebih lanjut</p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 text-gray-700">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span class="font-semibold">(0411) 585610</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <a href="mailto:ksr@pmiuhhas.or.id" class="text-red-600 hover:text-red-700 font-semibold">ksr@pmiuhhas.or.id</a>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ route('kontak') }}" class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleFaq(button) {
    const content = button.nextElementSibling;
    const icon = button.querySelector('svg');
    
    // Close all other FAQs
    document.querySelectorAll('.faq-toggle').forEach(btn => {
        if (btn !== button) {
            btn.nextElementSibling.classList.add('hidden');
            btn.querySelector('svg').classList.remove('rotate-180');
        }
    });
    
    // Toggle current FAQ
    content.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
}
</script>
@endpush

@endsection