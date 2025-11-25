@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-12">
    <div class="max-w-2xl w-full">
        <!-- Card Sukses -->
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
            
            <!-- Icon Success dengan Animasi -->
            <div class="flex justify-center mb-6">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center animate-bounce">
                    <svg class="w-12 h-12 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>

            <!-- Judul -->
            <h1 class="text-3xl font-bold text-center text-gray-900 mb-3">
                Permintaan Berhasil Dikirim!
            </h1>
            
            <p class="text-center text-gray-600 mb-8">
                Tim kami akan segera memproses permintaan Anda dan menghubungi nomor yang terdaftar.
            </p>

            <!-- Nomor Pelacakan Card -->
            <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-xl p-6 mb-8 border-2 border-red-200">
                <p class="text-sm text-gray-600 text-center mb-2 font-medium">Nomor Pelacakan</p>
                <div class="flex items-center justify-center gap-3">
                    <p class="text-4xl font-bold text-red-600 tracking-wider">
                        {{ $permintaan->nomor_pelacakan }}
                    </p>
                    <button onclick="copyTracking()" class="p-2 hover:bg-red-100 rounded-lg transition" title="Salin nomor">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-center text-gray-500 mt-2">
                    Simpan nomor ini untuk melacak status permintaan Anda
                </p>
            </div>

            <!-- Ringkasan Permintaan -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Ringkasan Permintaan
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between py-2 border-b border-blue-200">
                        <span class="text-gray-600">Nama Pasien</span>
                        <span class="font-semibold text-gray-900">{{ $permintaan->nama_pasien }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-blue-200">
                        <span class="text-gray-600">Golongan Darah</span>
                        <span class="font-semibold text-red-600">{{ $permintaan->gol_darah }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-blue-200">
                        <span class="text-gray-600">Tempat Dirawat</span>
                        <span class="font-semibold text-gray-900">{{ $permintaan->tempat_dirawat }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-blue-200">
                        <span class="text-gray-600">Jenis Permintaan</span>
                        <span class="font-semibold text-gray-900">{{ $permintaan->jenis_permintaan_label }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-blue-200">
                        <span class="text-gray-600">Jumlah Kantong</span>
                        <span class="font-semibold text-gray-900">{{ $permintaan->jumlah_kantong }} kantong</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-blue-200">
                        <span class="text-gray-600">Tingkat Urgensi</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $permintaan->urgensi_badge }}">
                            {{ $permintaan->tingkat_urgensi_label }}
                        </span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-blue-200">
                        <span class="text-gray-600">Kontak</span>
                        <span class="font-semibold text-gray-900">{{ $permintaan->nama_kontak }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-blue-200">
                        <span class="text-gray-600">No. HP</span>
                        <span class="font-semibold text-gray-900">{{ $permintaan->nomor_hp }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Status</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $permintaan->status_badge }}">
                            {{ $permintaan->status_label }}
                        </span>
                    </div>
                    @if($permintaan->riwayat_penyakit)
                    <div class="pt-3 border-t border-blue-200">
                        <span class="text-gray-600 block mb-2 font-medium">Riwayat Penyakit:</span>
                        <p class="text-sm text-gray-700 bg-white p-3 rounded-lg">{{ $permintaan->riwayat_penyakit }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Informasi Proses -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 mb-8">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div class="text-sm text-yellow-800">
                        <p class="font-bold mb-2">Langkah Selanjutnya:</p>
                        <ul class="space-y-2 ml-2">
                            <li class="flex items-start">
                                <span class="mr-2">1.</span>
                                <span>Tim kami akan memverifikasi permintaan Anda dalam 1-2 jam</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">2.</span>
                                <span>Anda akan dihubungi melalui nomor <strong>{{ $permintaan->nomor_hp }}</strong></span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">3.</span>
                                <span>Jika ada pendonor yang sesuai, kami akan menginformasikan detailnya</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('pendonor.dashboard') }}" 
                   class="flex-1 bg-red-600 text-white py-4 px-6 rounded-xl font-bold hover:bg-red-700 transition text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Kembali ke Dashboard
                    </div>
                </a>
                <a href="https://wa.me/6281234567890?text=Halo%20KSR%20PMI,%20saya%20ingin%20menanyakan%20status%20permintaan%20dengan%20nomor%20{{ $permintaan->nomor_pelacakan }}" 
                   target="_blank"
                   class="flex-1 bg-green-600 text-white py-4 px-6 rounded-xl font-bold hover:bg-green-700 transition text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Hubungi Kami
                    </div>
                </a>
            </div>
            
            <div class="text-center mt-6">
                <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                    Atau kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Info Card Tambahan -->
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>Butuh bantuan? Hubungi kami di <strong class="text-gray-700">+62 812-3456-7890</strong></p>
            <p class="mt-1">atau email ke <strong class="text-gray-700">info@ksrpmi-unhas.org</strong></p>
        </div>
    </div>
</div>

<script>
function copyTracking() {
    const trackingNumber = '{{ $permintaan->nomor_pelacakan }}';
    navigator.clipboard.writeText(trackingNumber).then(function() {
        // Show toast notification
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        toast.innerHTML = '✓ Nomor pelacakan berhasil disalin!';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    });
}

// Auto confetti animation on page load
window.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Permintaan berhasil dikirim!');
    console.log('📋 Nomor Pelacakan:', '{{ $permintaan->nomor_pelacakan }}');
});
</script>
@endsection