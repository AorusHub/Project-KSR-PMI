@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-2">Formulir Permintaan Donor Darah</h1>
        <p class="text-gray-600 mb-8">Isi formulir dengan lengkap untuk membantu kami mencari pendonor yang sesuai</p>

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-red-600 text-white font-bold" id="step-1">1</div>
                    <span class="ml-3 text-sm font-medium">Data Pasien</span>
                </div>
                <div class="flex-1 h-1 mx-4 bg-gray-300" id="line-1"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 text-gray-600 font-bold" id="step-2">2</div>
                    <span class="ml-3 text-sm font-medium text-gray-600">Kebutuhan</span>
                </div>
                <div class="flex-1 h-1 mx-4 bg-gray-300" id="line-2"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 text-gray-600 font-bold" id="step-3">3</div>
                    <span class="ml-3 text-sm font-medium text-gray-600">Kontak</span>
                </div>
            </div>
        </div>

        <!-- ✅ PASTIKAN ACTION & METHOD BENAR -->
        <form id="formulir-permintaan-darah" method="POST" action="{{ route('pendonor.permintaan-darah.simpan') }}">
            @csrf

            <!-- Step 1: Data Pasien -->
            <div class="konten-langkah bg-white rounded-lg shadow p-6" id="konten-langkah-1">
                <h2 class="text-xl font-semibold mb-6">Data Pasien</h2>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Nama Lengkap Pasien <span class="text-red-600">*</span></label>
                    <input type="text" name="nama_pasien" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Masukkan nama lengkap pasien" value="{{ old('nama_pasien') }}">
                    @error('nama_pasien')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Golongan Darah <span class="text-red-600">*</span></label>
                    <select name="golongan_darah" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option value="">Pilih golongan darah</option>
                        <option value="A+" {{ old('golongan_darah') == 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ old('golongan_darah') == 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ old('golongan_darah') == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ old('golongan_darah') == 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="AB+" {{ old('golongan_darah') == 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ old('golongan_darah') == 'AB-' ? 'selected' : '' }}>AB-</option>
                        <option value="O+" {{ old('golongan_darah') == 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ old('golongan_darah') == 'O-' ? 'selected' : '' }}>O-</option>
                    </select>
                    @error('golongan_darah')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Riwayat Penyakit (opsional)</label>
                    <textarea name="riwayat_penyakit" rows="3"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Tuliskan riwayat penyakit pasien jika ada">{{ old('riwayat_penyakit') }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Tempat Dirawat <span class="text-red-600">*</span></label>
                    <input type="text" name="tempat_dirawat" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Nama rumah sakit/klinik" value="{{ old('tempat_dirawat') }}">
                    @error('tempat_dirawat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="button" onclick="langkahSelanjutnya(2)"
                    class="w-full bg-red-600 text-white py-3 rounded-lg font-medium hover:bg-red-700 transition">
                    Selanjutnya
                </button>
            </div>

            <!-- Step 2: Kebutuhan Darah -->
            <div class="konten-langkah bg-white rounded-lg shadow p-6 hidden" id="konten-langkah-2">
                <h2 class="text-xl font-semibold mb-6">Kebutuhan Darah</h2>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Jenis Permintaan <span class="text-red-600">*</span></label>
                    <select name="jenis_permintaan" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option value="">Pilih jenis permintaan</option>
                        <option value="darah_lengkap" {{ old('jenis_permintaan') == 'darah_lengkap' ? 'selected' : '' }}>Darah Lengkap (Whole Blood)</option>
                        <option value="prc" {{ old('jenis_permintaan') == 'prc' ? 'selected' : '' }}>Packed Red Cells (PRC)</option>
                        <option value="trombosit" {{ old('jenis_permintaan') == 'trombosit' ? 'selected' : '' }}>Trombosit (TC)</option>
                        <option value="plasma" {{ old('jenis_permintaan') == 'plasma' ? 'selected' : '' }}>Plasma</option>
                    </select>
                    @error('jenis_permintaan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Jumlah Kantong Dibutuhkan <span class="text-red-600">*</span></label>
                    <input type="number" name="jumlah_kantong" min="1" max="10" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="1" value="{{ old('jumlah_kantong', 1) }}">
                    @error('jumlah_kantong')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Tingkat Urgensi <span class="text-red-600">*</span></label>
                    <select name="tingkat_urgensi" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option value="normal" {{ old('tingkat_urgensi') == 'normal' ? 'selected' : '' }}>Normal (2-3 hari)</option>
                        <option value="mendesak" {{ old('tingkat_urgensi') == 'mendesak' ? 'selected' : '' }}>Mendesak (< 24 jam)</option>
                        <option value="darurat" {{ old('tingkat_urgensi') == 'darurat' ? 'selected' : '' }}>Darurat (< 6 jam)</option>
                    </select>
                    @error('tingkat_urgensi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="button" onclick="langkahSebelumnya(1)"
                        class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-300 transition">
                        Kembali
                    </button>
                    <button type="button" onclick="langkahSelanjutnya(3)"
                        class="flex-1 bg-red-600 text-white py-3 rounded-lg font-medium hover:bg-red-700 transition">
                        Selanjutnya
                    </button>
                </div>
            </div>

            <!-- Step 3: Kontak -->
            <div class="konten-langkah bg-white rounded-lg shadow p-6 hidden" id="konten-langkah-3">
                <h2 class="text-xl font-semibold mb-6">Kontak Keluarga</h2>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Nama Kontak <span class="text-red-600">*</span></label>
                    <input type="text" name="nama_kontak" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Nama keluarga yang bisa dihubungi" value="{{ old('nama_kontak') }}">
                    @error('nama_kontak')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Nomor HP Aktif <span class="text-red-600">*</span></label>
                    <input type="tel" name="nomor_hp" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="08xxxxxxxxxx" value="{{ old('nomor_hp') }}">
                    @error('nomor_hp')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Hubungan dengan Pasien <span class="text-red-600">*</span></label>
                    <input type="text" name="hubungan_pasien" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                        placeholder="Contoh: Anak, Suami, Istri, dll" value="{{ old('hubungan_pasien') }}">
                    @error('hubungan_pasien')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-800">
                        <strong>Catatan:</strong> Pastikan nomor HP yang dicantumkan aktif dan dapat dihubungi. Tim kami akan segera menghubungi Anda setelah permintaan ini diproses.
                    </p>
                </div>

                <div class="flex gap-4">
                    <button type="button" onclick="langkahSebelumnya(2)"
                        class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-300 transition">
                        Kembali
                    </button>
                    
                    <!-- ✅ BUTTON SUBMIT YANG BENAR -->
                    <button type="submit" id="btn-submit"
                        class="flex-1 bg-red-600 text-white py-3 rounded-lg font-medium hover:bg-red-700 transition">
                        Kirim Permintaan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
console.log('🔧 Script loaded');

function langkahSelanjutnya(langkah) {
    console.log('▶️ Validasi langkah sebelum pindah ke:', langkah);
    
    const currentStep = document.querySelector('.konten-langkah:not(.hidden)');
    const inputs = currentStep.querySelectorAll('input[required], select[required]');
    let isValid = true;
    let pesanError = [];

    inputs.forEach(input => {
        if (input.tagName === 'SELECT') {
            if (!input.value || input.value === '') {
                isValid = false;
                input.classList.add('border-red-500');
                pesanError.push(input.previousElementSibling.textContent.replace('*', '').trim());
            } else {
                input.classList.remove('border-red-500');
            }
        } else {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('border-red-500');
                pesanError.push(input.previousElementSibling.textContent.replace('*', '').trim());
            } else {
                input.classList.remove('border-red-500');
            }
        }
    });

    if (!isValid) {
        console.log('❌ Validasi gagal:', pesanError);
        alert('Mohon lengkapi field berikut:\n- ' + pesanError.join('\n- '));
        return;
    }

    console.log('✅ Validasi berhasil');
    document.querySelectorAll('.konten-langkah').forEach(el => el.classList.add('hidden'));
    document.getElementById(`konten-langkah-${langkah}`).classList.remove('hidden');
    perbaruiProgress(langkah);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function langkahSebelumnya(langkah) {
    console.log('◀️ Kembali ke langkah:', langkah);
    document.querySelectorAll('.konten-langkah').forEach(el => el.classList.add('hidden'));
    document.getElementById(`konten-langkah-${langkah}`).classList.remove('hidden');
    perbaruiProgress(langkah);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function perbaruiProgress(langkahSaatIni) {
    for (let i = 1; i <= 3; i++) {
        const elemenLangkah = document.getElementById(`step-${i}`);
        const elemenGaris = document.getElementById(`line-${i}`);
        
        if (i <= langkahSaatIni) {
            elemenLangkah?.classList.remove('bg-gray-300', 'text-gray-600');
            elemenLangkah?.classList.add('bg-red-600', 'text-white');
            if (elemenGaris && i < langkahSaatIni) {
                elemenGaris.classList.remove('bg-gray-300');
                elemenGaris.classList.add('bg-red-600');
            }
        } else {
            elemenLangkah?.classList.remove('bg-red-600', 'text-white');
            elemenLangkah?.classList.add('bg-gray-300', 'text-gray-600');
            if (elemenGaris) {
                elemenGaris.classList.remove('bg-red-600');
                elemenGaris.classList.add('bg-gray-300');
            }
        }
    }
}

// ✅ SUBMIT HANDLER - PERBAIKAN FINAL
const formElement = document.getElementById('formulir-permintaan-darah');
const btnSubmit = document.getElementById('btn-submit');

console.log('📋 Form element:', formElement);
console.log('🔘 Button element:', btnSubmit);
console.log('🎯 Form action:', formElement?.action);

if (formElement && btnSubmit) {
    formElement.addEventListener('submit', function(e) {
        console.log('🚀 FORM SUBMIT TRIGGERED!');
        console.log('📍 Action URL:', this.action);
        console.log('📍 Method:', this.method);
        
        // Disable button & show loading
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<div class="flex items-center justify-center"><svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengirim...</div>';
        
        console.log('✅ Button disabled & loading');
        console.log('📤 Form akan dikirim ke server...');
        
        // JANGAN ADA e.preventDefault();
    });
} else {
    console.error('❌ ERROR: Form atau button tidak ditemukan!');
}

// Auto show error step
@if($errors->any())
window.addEventListener('DOMContentLoaded', function() {
    console.log('⚠️ Ada error validasi, showing error step');
    @if($errors->has('nama_pasien') || $errors->has('golongan_darah') || $errors->has('tempat_dirawat'))
        document.getElementById('konten-langkah-1').classList.remove('hidden');
        perbaruiProgress(1);
    @elseif($errors->has('jenis_permintaan') || $errors->has('jumlah_kantong') || $errors->has('tingkat_urgensi'))
        document.getElementById('konten-langkah-1').classList.add('hidden');
        document.getElementById('konten-langkah-2').classList.remove('hidden');
        perbaruiProgress(2);
    @elseif($errors->has('nama_kontak') || $errors->has('nomor_hp') || $errors->has('hubungan_pasien'))
        document.getElementById('konten-langkah-1').classList.add('hidden');
        document.getElementById('konten-langkah-3').classList.remove('hidden');
        perbaruiProgress(3);
    @endif
});
@endif
</script>
@endsection