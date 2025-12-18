{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\pendonor\formulir-permintaan-donor-darah.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 sm:py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-xl sm:text-2xl font-bold mb-1 sm:mb-2 text-gray-900 dark:text-white transition-colors">Formulir Permintaan Donor Darah</h1>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-6 sm:mb-8 transition-colors">Isi formulir dengan lengkap untuk membantu kami mencari pendonor yang sesuai</p>

        {{-- Progress Steps --}}
        <div class="mb-6 sm:mb-8 overflow-x-auto">
            <div class="flex items-center justify-between min-w-max sm:min-w-0">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-red-600 dark:bg-red-600 text-white font-bold text-sm sm:text-base transition-colors" id="step-1">1</div>
                    <span class="ml-2 sm:ml-3 text-xs sm:text-sm font-medium text-gray-900 dark:text-white transition-colors">Data Pasien</span>
                </div>
                <div class="flex-1 h-0.5 sm:h-1 mx-2 sm:mx-4 bg-gray-300 dark:bg-gray-600 transition-colors" id="line-1"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-400 font-bold text-sm sm:text-base transition-colors" id="step-2">2</div>
                    <span class="ml-2 sm:ml-3 text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 transition-colors" id="step-2-text">Kebutuhan</span>
                </div>
                <div class="flex-1 h-0.5 sm:h-1 mx-2 sm:mx-4 bg-gray-300 dark:bg-gray-600 transition-colors" id="line-2"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-400 font-bold text-sm sm:text-base transition-colors" id="step-3">3</div>
                    <span class="ml-2 sm:ml-3 text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 transition-colors" id="step-3-text">Kontak</span>
                </div>
            </div>
        </div>

        <form id="formulir-permintaan-darah" method="POST" action="{{ route('pendonor.permintaan-darah.simpan') }}">
            @csrf

            {{-- Step 1: Data Pasien --}}
            <div class="konten-langkah bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-gray-900/50 p-4 sm:p-6 border border-gray-100 dark:border-gray-700 transition-colors" id="konten-langkah-1">
                <h2 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6 text-gray-900 dark:text-white transition-colors">Data Pasien</h2>
                
                <div class="mb-3 sm:mb-4">
                    <label class="block text-xs sm:text-sm font-medium mb-1.5 sm:mb-2 text-gray-700 dark:text-gray-300 transition-colors">Nama Lengkap Pasien <span class="text-red-600 dark:text-red-400">*</span></label>
                    <input type="text" name="nama_pasien" required
                        class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 transition-colors text-sm sm:text-base"
                        placeholder="Masukkan nama lengkap pasien" value="{{ old('nama_pasien') }}">
                    @error('nama_pasien')
                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3 sm:mb-4">
                    <label class="block text-xs sm:text-sm font-medium mb-1.5 sm:mb-2 text-gray-700 dark:text-gray-300 transition-colors">Golongan Darah <span class="text-red-600 dark:text-red-400">*</span></label>
                    <select name="gol_darah" required class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 transition-colors text-sm sm:text-base">
                        <option value="" class="dark:bg-gray-700">Pilih golongan darah</option>
                        <option value="A+" {{ old('gol_darah') == 'A+' ? 'selected' : '' }} class="dark:bg-gray-700">A+</option>
                        <option value="A-" {{ old('gol_darah') == 'A-' ? 'selected' : '' }} class="dark:bg-gray-700">A-</option>
                        <option value="B+" {{ old('gol_darah') == 'B+' ? 'selected' : '' }} class="dark:bg-gray-700">B+</option>
                        <option value="B-" {{ old('gol_darah') == 'B-' ? 'selected' : '' }} class="dark:bg-gray-700">B-</option>
                        <option value="AB+" {{ old('gol_darah') == 'AB+' ? 'selected' : '' }} class="dark:bg-gray-700">AB+</option>
                        <option value="AB-" {{ old('gol_darah') == 'AB-' ? 'selected' : '' }} class="dark:bg-gray-700">AB-</option>
                        <option value="O+" {{ old('gol_darah') == 'O+' ? 'selected' : '' }} class="dark:bg-gray-700">O+</option>
                        <option value="O-" {{ old('gol_darah') == 'O-' ? 'selected' : '' }} class="dark:bg-gray-700">O-</option>
                    </select>
                    @error('gol_darah')
                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3 sm:mb-4">
                    <label class="block text-xs sm:text-sm font-medium mb-1.5 sm:mb-2 text-gray-700 dark:text-gray-300 transition-colors">Riwayat Penyakit</label>
                    <textarea name="riwayat" rows="3"
                        class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 transition-colors text-sm sm:text-base resize-none"
                        placeholder="Tuliskan riwayat penyakit pasien jika ada">{{ old('riwayat') }}</textarea>
                </div>

                <div class="mb-4 sm:mb-6">
                    <label class="block text-xs sm:text-sm font-medium mb-1.5 sm:mb-2 text-gray-700 dark:text-gray-300 transition-colors">Tempat Dirawat <span class="text-red-600 dark:text-red-400">*</span></label>
                    <input type="text" name="tempat_rawat" required
                        class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 transition-colors text-sm sm:text-base"
                        placeholder="Nama rumah sakit/klinik" value="{{ old('tempat_rawat') }}">
                    @error('tempat_rawat')
                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="button" onclick="langkahSelanjutnya(2)"
                    class="w-full bg-red-600 dark:bg-red-600 text-white py-2.5 sm:py-3 rounded-lg font-medium hover:bg-red-700 dark:hover:bg-red-700 transition-all text-sm sm:text-base transform active:scale-95">
                    Selanjutnya
                </button>
            </div>

            {{-- Step 2: Kebutuhan Darah --}}
            <div class="konten-langkah bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-gray-900/50 p-4 sm:p-6 hidden border border-gray-100 dark:border-gray-700 transition-colors" id="konten-langkah-2">
                <h2 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6 text-gray-900 dark:text-white transition-colors">Kebutuhan Darah</h2>
                
                <div class="mb-3 sm:mb-4">
                    <label class="block text-xs sm:text-sm font-medium mb-1.5 sm:mb-2 text-gray-700 dark:text-gray-300 transition-colors">Jenis Permintaan <span class="text-red-600 dark:text-red-400">*</span></label>
                    <select name="jenis_permintaan" required class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 transition-colors text-sm sm:text-base">
                        <option value="" class="dark:bg-gray-700">Pilih jenis permintaan</option>
                        <option value="Darah Lengkap (Whole Blood)" {{ old('jenis_permintaan') == 'Darah Lengkap (Whole Blood)' ? 'selected' : '' }} class="dark:bg-gray-700">Darah Lengkap (Whole Blood)</option>
                        <option value="Packed Red Cells (PRC)" {{ old('jenis_permintaan') == 'Packed Red Cells (PRC)' ? 'selected' : '' }} class="dark:bg-gray-700">Packed Red Cells (PRC)</option>
                        <option value="Trombosit (TC)" {{ old('jenis_permintaan') == 'Trombosit (TC)' ? 'selected' : '' }} class="dark:bg-gray-700">Trombosit (TC)</option>
                        <option value="Plasma" {{ old('jenis_permintaan') == 'Plasma' ? 'selected' : '' }} class="dark:bg-gray-700">Plasma</option>
                    </select>
                    @error('jenis_permintaan')
                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3 sm:mb-4">
                    <label class="block text-xs sm:text-sm font-medium mb-1.5 sm:mb-2 text-gray-700 dark:text-gray-300 transition-colors">Jumlah Kantong Dibutuhkan <span class="text-red-600 dark:text-red-400">*</span></label>
                    <input type="number" name="jumlah_kantong" min="1" max="10" required
                        class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 transition-colors text-sm sm:text-base"
                        placeholder="1" value="{{ old('jumlah_kantong', 1) }}">
                    @error('jumlah_kantong')
                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4 sm:mb-6">
                    <label class="block text-xs sm:text-sm font-medium mb-1.5 sm:mb-2 text-gray-700 dark:text-gray-300 transition-colors">Tingkat Urgensi <span class="text-red-600 dark:text-red-400">*</span></label>
                    <select name="tingkat_urgensi" required class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 transition-colors text-sm sm:text-base">
                        <option value="Normal" {{ old('tingkat_urgensi') == 'Normal' ? 'selected' : '' }} class="dark:bg-gray-700">Normal (2-3 hari)</option>
                        <option value="Mendesak" {{ old('tingkat_urgensi') == 'Mendesak' ? 'selected' : '' }} class="dark:bg-gray-700">Mendesak (< 24 jam)</option>
                        <option value="Sangat Mendesak" {{ old('tingkat_urgensi') == 'Sangat Mendesak' ? 'selected' : '' }} class="dark:bg-gray-700">Sangat Mendesak (< 6 jam)</option>
                    </select>
                    @error('tingkat_urgensi')
                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row gap-2.5 sm:gap-4">
                    <button type="button" onclick="langkahSebelumnya(1)"
                        class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 py-2.5 sm:py-3 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition-all text-sm sm:text-base transform active:scale-95">
                        Kembali
                    </button>
                    <button type="button" onclick="langkahSelanjutnya(3)"
                        class="flex-1 bg-red-600 dark:bg-red-600 text-white py-2.5 sm:py-3 rounded-lg font-medium hover:bg-red-700 dark:hover:bg-red-700 transition-all text-sm sm:text-base transform active:scale-95">
                        Selanjutnya
                    </button>
                </div>
            </div>

            {{-- Step 3: Kontak --}}
            <div class="konten-langkah bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-gray-900/50 p-4 sm:p-6 hidden border border-gray-100 dark:border-gray-700 transition-colors" id="konten-langkah-3">
                <h2 class="text-lg sm:text-xl font-semibold mb-4 sm:mb-6 text-gray-900 dark:text-white transition-colors">Kontak Keluarga</h2>
                
                <div class="mb-3 sm:mb-4">
                    <label class="block text-xs sm:text-sm font-medium mb-1.5 sm:mb-2 text-gray-700 dark:text-gray-300 transition-colors">Nama Kontak <span class="text-red-600 dark:text-red-400">*</span></label>
                    <input type="text" name="nama_kontak" required
                        class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 transition-colors text-sm sm:text-base"
                        placeholder="Nama keluarga yang bisa dihubungi" value="{{ old('nama_kontak') }}">
                    @error('nama_kontak')
                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3 sm:mb-4">
                    <label class="block text-xs sm:text-sm font-medium mb-1.5 sm:mb-2 text-gray-700 dark:text-gray-300 transition-colors">Nomor HP Aktif <span class="text-red-600 dark:text-red-400">*</span></label>
                    <input type="tel" name="no_hp" required
                        class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 transition-colors text-sm sm:text-base"
                        placeholder="08xxxxxxxxxx" value="{{ old('no_hp') }}">
                    @error('no_hp')
                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3 sm:mb-4">
                    <label class="block text-xs sm:text-sm font-medium mb-1.5 sm:mb-2 text-gray-700 dark:text-gray-300 transition-colors">Hubungan dengan Pasien <span class="text-red-600 dark:text-red-400">*</span></label>
                    <input type="text" name="hubungan" required
                        class="w-full px-3 sm:px-4 py-2 sm:py-2.5 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 transition-colors text-sm sm:text-base"
                        placeholder="Contoh: Anak, Suami, Istri, dll" value="{{ old('hubungan') }}">
                    @error('hubungan')
                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <input type="hidden" name="tanggal_hari" value="{{ date('Y-m-d') }}">

                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 sm:p-4 mb-4 sm:mb-6 transition-colors">
                    <p class="text-xs sm:text-sm text-blue-800 dark:text-blue-300 transition-colors">
                        <strong>Catatan:</strong> Pastikan nomor HP yang dicantumkan aktif dan dapat dihubungi. Tim kami akan segera menghubungi Anda setelah permintaan ini diproses.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-2.5 sm:gap-4">
                    <button type="button" onclick="langkahSebelumnya(2)"
                        class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 py-2.5 sm:py-3 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition-all text-sm sm:text-base transform active:scale-95">
                        Kembali
                    </button>
                    <button type="submit" id="btn-submit"
                        class="flex-1 bg-red-600 dark:bg-red-600 text-white py-2.5 sm:py-3 rounded-lg font-medium hover:bg-red-700 dark:hover:bg-red-700 transition-all text-sm sm:text-base transform active:scale-95">
                        Kirim Permintaan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ✅ LOADING MODAL --}}
<div id="loadingModal" class="hidden fixed inset-0 bg-gray-900 dark:bg-black bg-opacity-75 dark:bg-opacity-85 overflow-y-auto h-full w-full z-50 p-4 transition-colors">
    <div class="relative top-1/3 mx-auto w-full max-w-sm">
        <div class="flex flex-col items-center justify-center">
            <div class="relative mb-6 sm:mb-8">
                <div class="w-20 h-20 sm:w-24 sm:h-24 border-4 border-red-200 dark:border-red-900 border-t-red-600 dark:border-t-red-500 rounded-full animate-spin"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-red-600 dark:bg-red-500 rounded-full animate-pulse flex items-center justify-center">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <h3 class="text-lg sm:text-xl font-bold text-white mb-1 sm:mb-2">Mengirim Permintaan...</h3>
                <p class="text-xs sm:text-sm text-gray-300 dark:text-gray-400">Mohon tunggu sebentar</p>
            </div>
        </div>
    </div>
</div>

{{-- ✅ SUCCESS MODAL --}}
<div id="successModal" class="hidden fixed inset-0 bg-gray-900 dark:bg-black bg-opacity-75 dark:bg-opacity-85 overflow-y-auto h-full w-full z-50 p-4 transition-colors">
    <div class="relative top-1/4 mx-auto p-6 sm:p-8 border border-gray-200 dark:border-gray-700 w-full max-w-md shadow-lg rounded-xl sm:rounded-2xl bg-white dark:bg-gray-800 transition-colors">
        <div class="text-center">
            {{-- Success Icon --}}
            <div class="mx-auto flex items-center justify-center h-16 w-16 sm:h-20 sm:w-20 rounded-full bg-green-100 dark:bg-green-900/30 mb-4 sm:mb-6 transition-colors">
                <svg class="h-10 w-10 sm:h-12 sm:w-12 text-green-600 dark:text-green-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            
            {{-- Success Message --}}
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-3 transition-colors">Permintaan Berhasil Dikirim</h3>
            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-4 sm:mb-6 transition-colors">
                Tim kami akan segera memproses permintaan Anda dan menghubungi nomor yang terdaftar.
            </p>

            {{-- Nomor Pelacakan --}}
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3 sm:p-4 mb-4 sm:mb-6 transition-colors">
                <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400 mb-1 transition-colors">Nomor Pelacakan</p>
                <p class="text-xl sm:text-2xl font-bold text-red-600 dark:text-red-400 transition-colors" id="nomorPelacakan"></p>
                <p class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400 mt-1 sm:mt-2 transition-colors">Simpan nomor ini untuk melacak status permintaan Anda</p>
            </div>

            {{-- Button --}}
            <button onclick="window.location.href='{{ route('pendonor.dashboard') }}'"
                class="w-full px-4 sm:px-6 py-2.5 sm:py-3 bg-red-600 dark:bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 dark:hover:bg-red-700 transition-all text-sm sm:text-base transform active:scale-95">
                Kembali ke Beranda
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function langkahSelanjutnya(langkah) {
    const currentStep = document.querySelector('.konten-langkah:not(.hidden)');
    const inputs = currentStep.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;
    let pesanError = [];

    inputs.forEach(input => {
        if (input.tagName === 'SELECT') {
            if (!input.value || input.value === '') {
                isValid = false;
                input.classList.add('border-red-500', 'dark:border-red-500');
                pesanError.push(input.previousElementSibling.textContent.replace('*', '').trim());
            } else {
                input.classList.remove('border-red-500', 'dark:border-red-500');
            }
        } else {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('border-red-500', 'dark:border-red-500');
                pesanError.push(input.previousElementSibling.textContent.replace('*', '').trim());
            } else {
                input.classList.remove('border-red-500', 'dark:border-red-500');
            }
        }
    });

    if (!isValid) {
        alert('Mohon lengkapi field berikut:\n- ' + pesanError.join('\n- '));
        return;
    }

    document.querySelectorAll('.konten-langkah').forEach(el => el.classList.add('hidden'));
    document.getElementById(`konten-langkah-${langkah}`).classList.remove('hidden');
    perbaruiProgress(langkah);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function langkahSebelumnya(langkah) {
    document.querySelectorAll('.konten-langkah').forEach(el => el.classList.add('hidden'));
    document.getElementById(`konten-langkah-${langkah}`).classList.remove('hidden');
    perbaruiProgress(langkah);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function perbaruiProgress(langkahSaatIni) {
    for (let i = 1; i <= 3; i++) {
        const elemenLangkah = document.getElementById(`step-${i}`);
        const elemenGaris = document.getElementById(`line-${i}`);
        const elemenText = document.getElementById(`step-${i}-text`);
        
        if (i <= langkahSaatIni) {
            elemenLangkah?.classList.remove('bg-gray-300', 'dark:bg-gray-600', 'text-gray-600', 'dark:text-gray-400');
            elemenLangkah?.classList.add('bg-red-600', 'dark:bg-red-600', 'text-white');
            elemenText?.classList.remove('text-gray-600', 'dark:text-gray-400');
            elemenText?.classList.add('text-gray-900', 'dark:text-white');
            if (elemenGaris && i < langkahSaatIni) {
                elemenGaris.classList.remove('bg-gray-300', 'dark:bg-gray-600');
                elemenGaris.classList.add('bg-red-600', 'dark:bg-red-600');
            }
        } else {
            elemenLangkah?.classList.remove('bg-red-600', 'dark:bg-red-600', 'text-white');
            elemenLangkah?.classList.add('bg-gray-300', 'dark:bg-gray-600', 'text-gray-600', 'dark:text-gray-400');
            elemenText?.classList.remove('text-gray-900', 'dark:text-white');
            elemenText?.classList.add('text-gray-600', 'dark:text-gray-400');
            if (elemenGaris) {
                elemenGaris.classList.remove('bg-red-600', 'dark:bg-red-600');
                elemenGaris.classList.add('bg-gray-300', 'dark:bg-gray-600');
            }
        }
    }
}

// ✅ FORM SUBMIT HANDLER
const formElement = document.getElementById('formulir-permintaan-darah');
const btnSubmit = document.getElementById('btn-submit');

if (formElement && btnSubmit) {
    formElement.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Copy no_hp ke kontak_keluarga (untuk backwards compatibility)
        const noHp = document.querySelector('input[name="no_hp"]').value;
        document.getElementById('hidden_kontak').value = noHp;
        
        // Show loading modal
        document.getElementById('loadingModal').classList.remove('hidden');
        
        // Disable button
        btnSubmit.disabled = true;
        
        // Submit form via fetch
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Hide loading
            document.getElementById('loadingModal').classList.add('hidden');
            
            if (data.success) {
                // Show success modal with tracking number
                document.getElementById('nomorPelacakan').textContent = data.nomor_pelacakan || 'REQ' + Date.now();
                document.getElementById('successModal').classList.remove('hidden');
            } else {
                alert('Terjadi kesalahan: ' + (data.message || 'Silakan coba lagi'));
                btnSubmit.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('loadingModal').classList.add('hidden');
            alert('Terjadi kesalahan saat mengirim permintaan');
            btnSubmit.disabled = false;
        });
    });
}

// Show error step if validation fails
@if($errors->any())
window.addEventListener('DOMContentLoaded', function() {
    @if($errors->has('nama_pasien') || $errors->has('gol_darah') || $errors->has('tempat_rawat'))
        document.getElementById('konten-langkah-1').classList.remove('hidden');
        perbaruiProgress(1);
    @elseif($errors->has('jenis_permintaan') || $errors->has('jumlah_kantong') || $errors->has('tingkat_urgensi'))
        document.getElementById('konten-langkah-1').classList.add('hidden');
        document.getElementById('konten-langkah-2').classList.remove('hidden');
        perbaruiProgress(2);
    @elseif($errors->has('nama_kontak') || $errors->has('no_hp') || $errors->has('hubungan'))
        document.getElementById('konten-langkah-1').classList.add('hidden');
        document.getElementById('konten-langkah-3').classList.remove('hidden');
        perbaruiProgress(3);
    @endif
});
@endif
</script>
@endpush
@endsection