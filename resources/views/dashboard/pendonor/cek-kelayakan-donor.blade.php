@extends('layouts.app')

@section('title', 'Cek Kelayakan Donor - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-6 sm:py-8 transition-colors">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg dark:shadow-gray-900/50 overflow-hidden border border-gray-100 dark:border-gray-700 transition-colors">
            <div class="p-4 sm:p-6 md:p-8">
                <!-- Header -->
                <div class="mb-4 sm:mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-1 sm:mb-2 transition-colors">Cek Kelayakan Donor</h2>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 transition-colors">Jawab pertanyaan berikut untuk mengetahui apakah Anda memenuhi syarat donor darah</p>
                </div>

                <!-- Progress Bar -->
                <div class="mb-6 sm:mb-8">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 transition-colors">
                            Pertanyaan <span id="current-question" class="font-semibold text-gray-900 dark:text-white">1</span> dari <span id="total-questions" class="font-semibold text-gray-900 dark:text-white">10</span>
                        </span>
                        <span class="text-xs sm:text-sm font-semibold text-red-600 dark:text-red-400 transition-colors">
                            <span id="progress-percent">10</span>%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 sm:h-2.5 transition-colors">
                        <div class="bg-red-600 dark:bg-red-500 h-2 sm:h-2.5 rounded-full transition-all duration-300" id="progress-bar" style="width: 10%"></div>
                    </div>
                </div>

                <!-- Question Container -->
                <div id="question-container" class="mb-4 sm:mb-6">
                    <!-- Questions will be inserted here by JavaScript -->
                </div>

                <!-- Footer Note -->
                <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-200 dark:border-gray-700 transition-colors">
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 text-center transition-colors">
                        <svg class="w-4 h-4 inline-block mr-1 -mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Hasil cek kelayakan ini bersifat indikatif. Pemeriksaan medis lengkap akan dilakukan saat donor.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Menunggu Verifikasi -->
<div id="verificationModal" class="fixed inset-0 bg-gray-600 dark:bg-black bg-opacity-50 dark:bg-opacity-70 hidden overflow-y-auto h-full w-full z-50 transition-colors p-4">
    <div class="relative top-10 sm:top-20 mx-auto p-4 sm:p-5 border border-gray-200 dark:border-gray-700 w-full max-w-md shadow-lg rounded-lg bg-white dark:bg-gray-800 transition-colors">
        <div class="text-center">
            <div class="mb-4">
                <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center transition-colors">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-blue-600 dark:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-3 transition-colors">Menunggu Verifikasi</h3>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-4 sm:mb-6 px-2 transition-colors">Terima kasih! Data Anda sedang diverifikasi oleh tim kami. Kami akan menghubungi Anda segera.</p>
            <button onclick="window.location.href='{{ route('pendonor.dashboard') }}'" class="w-full sm:w-auto px-5 sm:px-6 py-2 sm:py-2.5 bg-red-600 dark:bg-red-600 text-white rounded-lg hover:bg-red-700 dark:hover:bg-red-700 transition-colors font-medium text-sm sm:text-base transform active:scale-95">
                Kembali ke Dashboard
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const questions = [
        { text: "Apakah Anda pernah mengalami alergi berat atau reaksi serius terhadap obat, makanan, atau transfusi darah sebelumnya?", field: 'alergi_obat_makanan_transfusi' },
        { text: "Apakah Anda sedang hamil, menyusui, atau baru melahirkan dalam 6 bulan terakhir? (khusus perempuan)", field: 'sedang_hamil_menyusui_melahirkan_6bulan' },
        { text: "Apakah Anda pernah mendapat operasi besar atau menerima transfusi darah dalam 1 tahun terakhir?", field: 'menerima_operasi_transfusi_1tahun' },
        { text: "Apakah Anda pernah bepergian ke daerah endemik malaria dalam 1 tahun terakhir?", field: 'ke_daerah_endemis_malaria_1tahun' },
        { text: "Apakah Anda sedang mengonsumsi obat-obatan tertentu saat ini?", field: 'konsumsi_obat' },
        { text: "Apakah Anda pernah memiliki atau memiliki riwayat penyakit menular seperti hepatitis, HIV/AIDS, atau sifilis?", field: 'riwayat_penyakit_hepatitis_hiv_sifilis' },
        { text: "Apakah dalam 6 bulan terakhir Anda pernah ditato, ditindik, atau menjalani akupuntur?", field: 'pernah_ditato_ditindik_diupanat_6bulan' },
        { text: "Apakah Anda sedang dalam kondisi sehat dan tidak sedang demam, batuk, pilek, atau flu?", field: 'sedang_sakit_demam_batuk_pilek_flu' }
    ];

    let currentQuestion = 0;
    let formData = {};
    let isEligible = true;
    const totalQuestions = questions.length;

    function updateProgress() {
        const progress = ((currentQuestion + 1) / totalQuestions) * 100;
        document.getElementById('current-question').textContent = currentQuestion + 1;
        document.getElementById('total-questions').textContent = totalQuestions;
        document.getElementById('progress-percent').textContent = Math.round(progress);
        document.getElementById('progress-bar').style.width = progress + '%';
    }

    function showQuestion() {
        const container = document.getElementById('question-container');
        const prevBtn = currentQuestion > 0 ? 
            `<button onclick="previousQuestion()" type="button" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-xs sm:text-sm font-medium transition-colors mt-3 sm:mt-4 inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Pertanyaan Sebelumnya
            </button>` : '';
        
        container.innerHTML = `
            <div class="space-y-4 sm:space-y-6">
                <p class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white transition-colors leading-relaxed">${questions[currentQuestion].text}</p>
                
                <div class="space-y-2.5 sm:space-y-3">
                    <label class="flex items-center p-3 sm:p-4 border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700/50 rounded-lg cursor-pointer hover:border-red-300 dark:hover:border-red-500 transition-all group">
                        <input type="radio" name="q${currentQuestion}" value="1" onchange="handleAnswer(1)" class="w-4 h-4 text-red-600 dark:text-red-500 focus:ring-red-500 dark:focus:ring-red-400 border-gray-300 dark:border-gray-600">
                        <span class="ml-2.5 sm:ml-3 text-sm sm:text-base text-gray-700 dark:text-gray-300 font-medium transition-colors flex items-center">
                            <svg class="w-2 h-2 text-red-600 dark:text-red-400 mr-2" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="4"/>
                            </svg>
                            Ya
                        </span>
                    </label>
                    
                    <label class="flex items-center p-3 sm:p-4 border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700/50 rounded-lg cursor-pointer hover:border-red-300 dark:hover:border-red-500 transition-all group">
                        <input type="radio" name="q${currentQuestion}" value="0" onchange="handleAnswer(0)" class="w-4 h-4 text-red-600 dark:text-red-500 focus:ring-red-500 dark:focus:ring-red-400 border-gray-300 dark:border-gray-600">
                        <span class="ml-2.5 sm:ml-3 text-sm sm:text-base text-gray-700 dark:text-gray-300 font-medium transition-colors">Tidak</span>
                    </label>
                </div>

                ${prevBtn}
            </div>
        `;

        // Restore previous answer if exists
        const field = questions[currentQuestion].field;
        if (formData[field] !== undefined) {
            const radio = document.querySelector(`input[name="q${currentQuestion}"][value="${formData[field]}"]`);
            if (radio) radio.checked = true;
        }
    }

    function handleAnswer(answer) {
        const field = questions[currentQuestion].field;
        formData[field] = answer;
        
        // ✅ VALIDASI: Pertanyaan 0-6 harus "Tidak" (0), pertanyaan 7 harus "Ya" (1)
        if (currentQuestion <= 6 && answer === 1) {
            isEligible = false;
        }
        if (currentQuestion === 7 && answer === 0) {
            isEligible = false;
        }

        // Move to next question or finish
        if (currentQuestion < totalQuestions - 1) {
            setTimeout(() => {
                currentQuestion++;
                updateProgress();
                showQuestion();
            }, 300);
        } else {
            // ✅ SUBMIT KE DATABASE
            setTimeout(() => submitVerifikasi(), 500);
        }
    }

    function previousQuestion() {
        if (currentQuestion > 0) {
            currentQuestion--;
            updateProgress();
            showQuestion();
        }
    }

    function showNotEligibleModal() {
        window.location.href = '{{ route("pendonor.dashboard") }}';
    }

    function showVerificationModal() {
        document.getElementById('verificationModal').classList.remove('hidden');
    }

    // ✅ SUBMIT DATA KE CONTROLLER
    async function submitVerifikasi() {
        try {
            const response = await fetch('{{ route("pendonor.cek-kelayakan-donor.submit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    golongan_darah: '{{ auth()->user()->pendonor->golongan_darah ?? "O+" }}',
                    berat_badan: 50, // Default, nanti bisa diganti dengan input form
                    ...formData
                })
            });

            const result = await response.json();

            if (result.success) {
                showVerificationModal();
            } else {
                alert('Terjadi kesalahan: ' + result.message);
            }

        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim data');
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updateProgress();
        showQuestion();
    });
</script>
@endpush
@endsection