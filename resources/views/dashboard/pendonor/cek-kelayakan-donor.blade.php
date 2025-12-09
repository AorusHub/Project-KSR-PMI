{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\pendonor\cek-kelayakan-donor.blade.php --}}
@extends('layouts.app')

@section('title', 'Cek Kelayakan Donor - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6 md:p-8">
                <!-- Header -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Cek Kelayakan Donor</h2>
                    <p class="text-gray-600">Jawab pertanyaan berikut untuk mengetahui apakah Anda memenuhi syarat donor darah</p>
                </div>

                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-600">Pertanyaan <span id="current-question" class="font-semibold">1</span> dari <span id="total-questions" class="font-semibold">10</span></span>
                        <span class="text-sm font-semibold text-red-600"><span id="progress-percent">10</span>%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-red-600 h-2.5 rounded-full transition-all duration-300" id="progress-bar" style="width: 10%"></div>
                    </div>
                </div>

                <!-- Question Container -->
                <div id="question-container" class="mb-6">
                    <!-- Questions will be inserted here by JavaScript -->
                </div>

                <!-- Footer Note -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-500 text-center">
                        <i class="fas fa-info-circle mr-1"></i>
                        Hasil cek kelayakan ini bersifat indikatif. Pemeriksaan medis lengkap akan dilakukan saat donor.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Belum Memenuhi Syarat -->
{{-- <div id="notEligibleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="text-center">
            <div class="mb-4">
                <i class="fas fa-times-circle text-red-600" style="font-size: 80px;"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Belum Memenuhi Syarat</h3>
            <p class="text-gray-600 mb-6 px-4">
                Berdasarkan hasil pemeriksaan Anda saat ini, Anda belum memenuhi syarat untuk donor darah. 
                Hal ini untuk menjaga kesehatan Anda dan keamanan darah yang didonorkan. 
                Silakan konsultasi dengan petugas medis untuk informasi lebih lanjut.
            </p>
            <div class="flex gap-3 justify-center">
                <button onclick="window.location.reload()" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                    Cek Lagi
                </button>
                <button onclick="window.location.href='{{ route('pendonor.dashboard') }}'" class="px-6 py-2 bg-white border-2 border-red-600 text-red-600 rounded-lg hover:bg-red-50 transition-colors font-medium">
                    Kembali
                </button>
            </div>
        </div>
    </div>
</div> --}}

<!-- Modal Menunggu Verifikasi -->
<div id="verificationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="text-center">
            <div class="mb-4">
                <i class="far fa-clock text-blue-600" style="font-size: 80px;"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Menunggu Verifikasi</h3>
            <p class="text-gray-600 mb-6">Terima kasih! Data Anda sedang diverifikasi oleh tim kami. Kami akan menghubungi Anda segera.</p>
            <button onclick="window.location.href='{{ route('pendonor.dashboard') }}'" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
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
            `<button onclick="previousQuestion()" type="button" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                ← Pertanyaan Sebelumnya
            </button>` : '';
        
        container.innerHTML = `
            <div class="space-y-6">
                <p class="text-lg font-semibold text-gray-900">${questions[currentQuestion].text}</p>
                
                <div class="space-y-3">
                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-red-300 transition-colors">
                        <input type="radio" name="q${currentQuestion}" value="1" onchange="handleAnswer(1)" class="w-4 h-4 text-red-600 focus:ring-red-500">
                        <span class="ml-3 text-gray-700 font-medium">
                            <i class="fas fa-circle text-red-600 text-xs mr-2"></i>Ya
                        </span>
                    </label>
                    
                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-red-300 transition-colors">
                        <input type="radio" name="q${currentQuestion}" value="0" onchange="handleAnswer(0)" class="w-4 h-4 text-red-600 focus:ring-red-500">
                        <span class="ml-3 text-gray-700 font-medium">Tidak</span>
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