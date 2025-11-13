{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\dashboard\dev\edit_kegiatan.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Edit Kegiatan Donor</h1>
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <form id="formEditKegiatan" action="{{ route('admin.kegiatan.update', $kegiatan->kegiatan_id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Kegiatan --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_kegiatan" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                        placeholder="Contoh: Donor Darah Kampus UNHAS"
                        value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}">
                    @error('nama_kegiatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        value="{{ old('tanggal', $kegiatan->tanggal->format('Y-m-d')) }}">
                    @error('tanggal')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Waktu Mulai & Waktu Selesai --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Waktu mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="waktu_mulai" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            value="{{ old('waktu_mulai', substr($kegiatan->waktu_mulai, 0, 5)) }}">
                        @error('waktu_mulai')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Waktu Selesai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="waktu_selesai" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            value="{{ old('waktu_selesai', substr($kegiatan->waktu_selesai, 0, 5)) }}">
                        @error('waktu_selesai')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Lokasi --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Lokasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="lokasi" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                        placeholder="Alamat lengkap lokasi kegiatan"
                        value="{{ old('lokasi', $kegiatan->lokasi) }}">
                    @error('lokasi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                        placeholder="Deskripsi kegiatan...">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                    @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Hidden Fields --}}
                <input type="hidden" name="target_donor" value="{{ old('target_donor', $kegiatan->target_donor ?? 100) }}">
                <input type="hidden" name="status" value="{{ old('status', $kegiatan->status) }}">

                {{-- Buttons --}}
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.kegiatan.index') }}" 
                        class="px-6 py-3 border border-gray-300 text-gray-700 font-medium text-center rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                        class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
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
        <h3 class="text-xl font-bold text-gray-900 mb-2">Update Kegiatan Berhasil</h3>
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