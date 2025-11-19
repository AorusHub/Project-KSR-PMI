{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\auth\forgot-password.blade.php --}}
@extends('layouts.guest')

@section('title', 'Reset Password - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        
        {{-- Header --}}
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="Logo KSR PMI" class="mx-auto h-20 w-20 object-contain mb-4" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2280%22 height=%2280%22 viewBox=%220 0 80 80%22%3E%3Ccircle cx=%2240%22 cy=%2240%22 r=%2240%22 fill=%22%23dc2626%22/%3E%3Cpath d=%22M40 15 L48 35 L68 35 L53 48 L58 68 L40 56 L22 68 L27 48 L12 35 L32 35 Z%22 fill=%22white%22/%3E%3C/svg%3E'">
            
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Reset Password</h2>
        </div>

        {{-- Main Card --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <form action="{{ route('password.update') }}" method="POST" class="p-6 space-y-6" id="resetPasswordForm">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email ?? request()->email }}">

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Password Baru Input --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password Baru
                    </label>
                    <div class="relative">
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            required
                            autofocus
                            placeholder="Masukkan password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('password') border-red-500 @enderror"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password')" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                        >
                            <svg id="eye-password" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password Input --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            type="password" 
                            required
                            placeholder="Masukkan password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password_confirmation')" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                        >
                            <svg id="eye-password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button 
                    type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                >
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Success Modal (Popup) --}}
<div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-8 transform transition-all">
        <div class="text-center">
            {{-- Success Icon --}}
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            
            {{-- Success Message --}}
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Reset Password Berhasil!</h3>
            <p class="text-sm text-gray-600 mb-6">
                Password Anda telah berhasil direset.<br>
                Anda akan diarahkan ke halaman login dalam <span id="countdown" class="font-bold text-red-600">10</span> detik.
            </p>
            
            {{-- OK Button --}}
            <button 
                onclick="redirectToLogin()"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
            >
                Login Sekarang
            </button>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);
}

let countdownValue = 10;
let countdownInterval;

function showSuccessModal() {
    document.getElementById('successModal').classList.remove('hidden');
    
    countdownInterval = setInterval(() => {
        countdownValue--;
        document.getElementById('countdown').textContent = countdownValue;
        
        if (countdownValue <= 0) {
            clearInterval(countdownInterval);
            redirectToLogin();
        }
    }, 1000);
}

function redirectToLogin() {
    clearInterval(countdownInterval);
    window.location.href = "{{ route('login') }}";
}

// Handle form submit dengan AJAX
document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Memproses...';
    
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
        if (data.success) {
            showSuccessModal();
        } else {
            alert(data.message || 'Terjadi kesalahan');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Reset Password';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Fallback: submit form normally
        this.submit();
    });
});
</script>
@endsection