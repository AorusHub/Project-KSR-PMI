{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\auth\verify-forgot-otp.blade.php --}}
@extends('layouts.guest')

@section('title', 'Verifikasi OTP Reset Password - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        
        {{-- Header --}}
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="Logo KSR PMI" class="mx-auto h-16 w-16 object-contain mb-4" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2264%22 height=%2264%22 viewBox=%220 0 64 64%22%3E%3Ccircle cx=%2232%22 cy=%2232%22 r=%2232%22 fill=%22%23dc2626%22/%3E%3Cpath d=%22M32 12 L38 28 L54 28 L42 38 L46 54 L32 45 L18 54 L22 38 L10 28 L26 28 Z%22 fill=%22white%22/%3E%3C/svg%3E'">
            
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-900">Verifikasi Kode OTP</h2>
            <p class="mt-2 text-sm text-gray-600">
                Kami telah mengirim kode 6 digit ke<br>
                <span class="font-semibold text-gray-900">{{ $email ?? session('email') ?? 'email Anda' }}</span>
            </p>
        </div>

        {{-- OTP Form Card --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <form action="{{ route('password.verify.otp') }}" method="POST" class="p-6 space-y-6" id="otpForm">
                @csrf

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                {{-- Error Messages from Backend --}}
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm">
                                @foreach ($errors->all() as $error)
                                    <p class="mb-1">{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Dynamic Error Container (for JS errors) --}}
                <div id="errorContainer" class="hidden bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p id="errorMessage" class="text-sm"></p>
                    </div>
                </div>

                <input type="hidden" name="email" value="{{ $email ?? session('email') }}">

                {{-- 6 OTP Input Boxes --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3 text-center">
                        Masukkan Kode OTP
                    </label>
                    <div class="flex justify-center gap-2 mb-3">
                        @for ($i = 0; $i < 6; $i++)
                        <input 
                            type="text" 
                            maxlength="1" 
                            pattern="[0-9]"
                            inputmode="numeric"
                            class="otp-input w-12 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('otp') border-red-500 @enderror"
                            data-index="{{ $i }}"
                            autocomplete="off"
                        >
                        @endfor
                    </div>
                    <p class="text-xs text-gray-500 text-center">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        Kode OTP berlaku selama 10 menit
                    </p>
                </div>

                {{-- Hidden input untuk submit --}}
                <input type="hidden" name="otp" id="otpValue">

                {{-- Submit Button --}}
                <button 
                    type="submit"
                    id="submitBtn"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:bg-gray-400 disabled:cursor-not-allowed"
                >
                    Verifikasi OTP
                </button>

                {{-- Divider --}}
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-2 bg-white text-gray-500">atau</span>
                    </div>
                </div>

                {{-- Resend OTP --}}
                <div class="text-center">
                    <p class="text-sm text-gray-600 mb-2">
                        Tidak menerima kode?
                    </p>
                    <button 
                        type="button"
                        onclick="resendOTP()"
                        id="resendBtn"
                        class="text-sm font-semibold text-red-600 hover:text-red-700 disabled:text-gray-400 disabled:cursor-not-allowed"
                    >
                        Kirim Ulang OTP
                    </button>
                    <p id="countdown" class="text-xs text-gray-500 mt-1"></p>
                </div>

                {{-- Back to Login --}}
                <div class="text-center pt-4 border-t">
                    <a href="{{ route('login') }}" class="inline-flex items-center text-sm font-semibold text-red-600 hover:text-red-700">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Login
                    </a>
                </div>
            </form>
        </div>

        {{-- Footer Note --}}
        <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">Tips:</p>
                    <ul class="text-xs space-y-1">
                        <li>• Periksa folder spam/junk jika tidak menerima email</li>
                        <li>• Pastikan kode OTP yang dimasukkan benar</li>
                        <li>• Kode OTP hanya berlaku 10 menit</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const inputs = document.querySelectorAll('.otp-input');
const form = document.getElementById('otpForm');
const otpValue = document.getElementById('otpValue');
const errorContainer = document.getElementById('errorContainer');
const errorMessage = document.getElementById('errorMessage');
const submitBtn = document.getElementById('submitBtn');

// Auto focus first input
inputs[0].focus();

inputs.forEach((input, index) => {
    // Only allow numbers
    input.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Remove error styling when typing
        this.classList.remove('border-red-500');
        
        // Auto move to next input
        if (this.value && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
        
        // Update hidden input value
        updateOTPValue();
        
        // Clear errors when typing
        hideErrors();
    });

    // Handle backspace
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !this.value && index > 0) {
            inputs[index - 1].focus();
        }
    });

    // Handle paste
    input.addEventListener('paste', function(e) {
        e.preventDefault();
        const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');
        
        for (let i = 0; i < pastedData.length && index + i < inputs.length; i++) {
            inputs[index + i].value = pastedData[i];
            inputs[index + i].classList.remove('border-red-500');
        }
        
        const lastIndex = Math.min(index + pastedData.length, inputs.length - 1);
        inputs[lastIndex].focus();
        
        updateOTPValue();
        hideErrors();
    });
});

function updateOTPValue() {
    let otp = '';
    inputs.forEach(input => {
        otp += input.value;
    });
    otpValue.value = otp;
}

function showError(message) {
    errorMessage.textContent = message;
    errorContainer.classList.remove('hidden');
    
    // Highlight OTP inputs with error
    inputs.forEach(input => {
        input.classList.add('border-red-500');
    });
    
    // Scroll to error
    errorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function hideErrors() {
    errorContainer.classList.add('hidden');
    errorMessage.textContent = '';
    
    // Remove error styling
    inputs.forEach(input => {
        input.classList.remove('border-red-500');
    });
}

// Countdown timer
let timeLeft = 60;
let countdownTimer;

function startCountdown() {
    const resendBtn = document.getElementById('resendBtn');
    const countdown = document.getElementById('countdown');
    resendBtn.disabled = true;
    
    countdownTimer = setInterval(() => {
        timeLeft--;
        countdown.textContent = `Kirim ulang dalam ${timeLeft} detik`;
        
        if (timeLeft <= 0) {
            clearInterval(countdownTimer);
            resendBtn.disabled = false;
            countdown.textContent = '';
            timeLeft = 60;
        }
    }, 1000);
}

function resendOTP() {
    inputs.forEach(input => {
        input.value = '';
        input.classList.remove('border-red-500');
    });
    inputs[0].focus();
    hideErrors();
    
    const resendBtn = document.getElementById('resendBtn');
    resendBtn.disabled = true;
    resendBtn.textContent = 'Mengirim...';
    
    fetch('{{ route("password.resend.otp") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            email: '{{ $email ?? session("email") }}'
        })
    })
    .then(response => response.json())
    .then(data => {
        resendBtn.textContent = 'Kirim Ulang OTP';
        
        if (data.success) {
            alert('✅ Kode OTP baru telah dikirim ke email Anda');
            startCountdown();
        } else {
            showError(data.message || 'Gagal mengirim OTP. Silakan coba lagi.');
            resendBtn.disabled = false;
        }
    })
    .catch(error => {
        resendBtn.textContent = 'Kirim Ulang OTP';
        resendBtn.disabled = false;
        showError('Gagal mengirim OTP. Silakan coba lagi.');
    });
}

window.onload = function() {
    startCountdown();
};

form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (otpValue.value.length !== 6) {
        showError('Silakan masukkan 6 digit kode OTP');
        return;
    }
    
    // Disable submit button
    submitBtn.disabled = true;
    submitBtn.textContent = 'Memverifikasi...';
    
    // Submit form
    this.submit();
});
</script>
@endsection