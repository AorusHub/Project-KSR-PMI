{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\dev\create_kegiatan.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4">
    <div class="max-w-xl mx-auto">
        
        {{-- Form Card --}}
        <div class="bg-white rounded-xl shadow-lg p-8 relative">
            {{-- Close Button --}}
            <a href="{{ route('admin.kegiatan.index') }}" 
                class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>

            {{-- Header --}}
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Buat Kegiatan Donor Baru</h1>

            {{-- Form --}}
            <form action="{{ route('admin.kegiatan.store') }}" method="POST">
                @csrf

                {{-- Nama Kegiatan --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Nama Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_kegiatan" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all text-gray-700" 
                        placeholder="Contoh: Donor Darah Kampus UNHAS"
                        value="{{ old('nama_kegiatan') }}">
                    @error('nama_kegiatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all text-gray-700"
                        value="{{ old('tanggal') }}">
                    @error('tanggal')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Waktu Mulai & Waktu Selesai --}}
                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Waktu mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="waktu_mulai" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all text-gray-700"
                            value="{{ old('waktu_mulai', '08:00') }}">
                        @error('waktu_mulai')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Waktu Selesai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="waktu_selesai" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all text-gray-700"
                            value="{{ old('waktu_selesai', '14:00') }}">
                        @error('waktu_selesai')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Lokasi --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Lokasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="lokasi" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all text-gray-700" 
                        placeholder="Alamat lengkap lokasi kegiatan"
                        value="{{ old('lokasi') }}">
                    @error('lokasi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all resize-none text-gray-700" 
                        placeholder="Deskripsi kegiatan...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Hidden Fields --}}
                <input type="hidden" name="target_donor" value="100">
                <input type="hidden" name="status" value="Planned">

                {{-- Buttons --}}
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('admin.kegiatan.index') }}" 
                        class="px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 font-semibold text-center rounded-lg hover:bg-gray-50 transition-all">
                        Batal
                    </a>
                    <button type="submit" 
                        class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-all shadow-md hover:shadow-lg">
                        Buat Kegiatan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

{{-- Modal Success --}}
<div id="successModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 max-w-sm mx-4 text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Membuat Kegiatan Berhasil</h3>
        <button onclick="closeSuccessModal()" 
            class="mt-4 px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
            OK
        </button>
    </div>
</div>

@push('scripts')
<script>
@if(session('success'))
    showSuccessModal();
@endif

function showSuccessModal() {
    document.getElementById('successModal').classList.remove('hidden');
    setTimeout(function() {
        window.location.href = "{{ route('admin.kegiatan.index') }}";
    }, 2000);
}

function closeSuccessModal() {
    window.location.href = "{{ route('admin.kegiatan.index') }}";
}
</script>
@endpush
@endsection