{{-- filepath: e:\Project-KSR-PMI\resources\views\dashboard\pendonor\pendonor-profile.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Success Message --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- Error Messages --}}
        @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <p class="text-red-700 font-medium mb-2">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Left Sidebar - Profile Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    
                    {{-- Header Card --}}
                    <div class="text-left mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Profil Pengguna</h2>
                        <p class="text-sm text-gray-500 mt-1">Menampilkan informasi profil</p>
                    </div>

                    {{-- Total Donasi Card --}}
                    <div class="bg-white border border-gray-200 rounded-xl p-4 mb-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Total Donasi</p>
                                <p class="text-4xl font-bold text-red-600">{{ $totalDonasi ?? 5 }}</p>
                                <p class="text-xs text-gray-500 mt-1">Kantong darah didonorkan</p>
                            </div>
                            <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Donasi Terakhir Card --}}
                    <div class="bg-white border border-gray-200 rounded-xl p-4 mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-900">Donasi Terakhir</p>
                            <div class="w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ $donorTerakhir ?? '17/9/2025' }}</p>
                        <p class="text-xs text-gray-500 mt-1">PMI Kota Makassar</p>
                    </div>

                    {{-- Donor Berikutnya Card --}}
                    <div class="bg-white border border-gray-200 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-900">Donor Berikutnya</p>
                            <div class="w-8 h-8 bg-green-50 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-gray-900">{{ $donorBerikutnya ?? '16/12/2025' }}</p>
                        <p class="text-xs text-gray-500 mt-1">Pengguna dapat donor kembali</p>
                    </div>

                </div>
            </div>

            {{-- Right Content - Editable Profile Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm p-8">
                    
                    {{-- Avatar & Name --}}
                    <div class="flex flex-col items-center mb-8 pb-6 border-b border-gray-200">
                        <div class="w-24 h-24 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center text-white text-4xl font-bold shadow-lg mb-4">
                            {{ strtoupper(substr($pendonor->nama ?? 'Nama Pendonor', 0, 1)) }}
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 text-center">{{ $pendonor->nama ?? 'Nama Pendonor' }}</h2>
                        <p class="text-sm text-gray-600 mt-1">Golongan Darah: {{ $pendonor->golongan_darah ?? 'A+' }}</p>
                    </div>

                    {{-- Editable Form --}}
                    <form method="POST" action="{{ route('pendonor.profil.update') }}" id="profileForm">
                        @csrf
                        @method('PUT')

                        <div class="space-y-0">

                            {{-- Tanggal Lahir (Editable) --}}
                            <div class="grid grid-cols-2 gap-4 py-4 border-b border-gray-100 group">
                                <span class="text-sm text-gray-700 flex items-center">Tanggal Lahir</span>
                                <div class="flex items-center justify-end space-x-2">
                                    <input type="date" 
                                           name="tanggal_lahir"
                                           value="{{ old('tanggal_lahir', $pendonor->tanggal_lahir ? $pendonor->tanggal_lahir->format('Y-m-d') : '') }}"
                                           class="text-sm text-gray-900 text-right font-medium border-0 bg-transparent focus:bg-gray-50 focus:border-gray-300 focus:ring-2 focus:ring-red-500 rounded px-2 py-1 transition"
                                           required>
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-red-600 transition" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Jenis Kelamin (Editable) --}}
                            <div class="grid grid-cols-2 gap-4 py-4 border-b border-gray-100 group">
                                <span class="text-sm text-gray-700 flex items-center">Jenis Kelamin</span>
                                <div class="flex items-center justify-end space-x-2">
                                    <select name="jenis_kelamin"
                                            class="text-sm text-gray-900 text-right font-medium border-0 bg-transparent focus:bg-gray-50 focus:border-gray-300 focus:ring-2 focus:ring-red-500 rounded px-2 py-1 transition"
                                            required>
                                        <option value="L" {{ old('jenis_kelamin', $pendonor->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin', $pendonor->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-red-600 transition" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- NIK (Read Only) --}}
                            <div class="grid grid-cols-2 gap-4 py-4 border-b border-gray-100">
                                <span class="text-sm text-gray-700">NIK</span>
                                <span class="text-sm text-gray-500 text-right font-medium">{{ $pendonor->NIK ?? '123456789' }}</span>
                            </div>

                            {{-- Email (Read Only) --}}
                            <div class="grid grid-cols-2 gap-4 py-4 border-b border-gray-100">
                                <span class="text-sm text-gray-700">Email</span>
                                <span class="text-sm text-gray-500 text-right font-medium">{{ Auth::user()->email ?? 'pendonor@demo.com' }}</span>
                            </div>

                            {{-- No. HP (Read Only) --}}
                            <div class="grid grid-cols-2 gap-4 py-4 border-b border-gray-100">
                                <span class="text-sm text-gray-700">No. HP</span>
                                <span class="text-sm text-gray-500 text-right font-medium">{{ $pendonor->no_hp ?? '081234567890' }}</span>
                            </div>

                            {{-- Password (Editable) --}}
                            <div class="grid grid-cols-2 gap-4 py-4 border-b border-gray-100 group">
                                <span class="text-sm text-gray-700 flex items-center">Password</span>
                                <div class="flex items-center justify-end space-x-2">
                                    <div class="relative">
                                        <input type="password" 
                                               id="password"
                                               name="password"
                                               placeholder="Kosongkan jika tidak ingin mengubah"
                                               class="text-sm text-gray-900 text-right font-medium border-0 bg-transparent focus:bg-gray-50 focus:border-gray-300 focus:ring-2 focus:ring-red-500 rounded px-2 py-1 pr-8 transition w-full">
                                        <button type="button" 
                                                onclick="togglePassword()"
                                                class="absolute right-0 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-red-600 transition" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                </div>
                            </div>

                        </div>

                        {{-- Save Button --}}
                        <div class="pt-8 flex justify-center">
                            <button type="submit" 
                                    class="px-32 py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition-all shadow-md hover:shadow-lg focus:ring-4 focus:ring-red-300">
                                SIMPAN PERUBAHAN
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
    } else {
        input.type = 'password';
        icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    }
}
</script>
@endsection