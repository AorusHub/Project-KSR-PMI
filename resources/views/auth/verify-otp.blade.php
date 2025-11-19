{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\auth\verify-otp.blade.php --}}
@extends('layouts.guest')

@section('title', 'Verifikasi OTP - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        
        {{-- Header --}}
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="Logo KSR PMI" class="mx-auto h-16 w-16 object-contain mb-4" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2264%22 height=%2264%22 viewBox=%220 0 64 64%22%3E%3Ccircle cx=%2232%22 cy=%2232%22 r=%2232%22 fill=%22%23dc2626%22/%3E%3Cpath d=%22M32 12 L38 28 L54 28 L42 38 L46 54 L32 45 L18 54 L22 38 L10 28 L26 28 Z%22 fill=%22white%22/%3E%3C/svg%3E'">
            
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-900">Verifikasi Kode OTP</h2>
            <p class="mt-2 text-sm text-gray-600">
                Kami telah mengirim kode 6 digit ke <br>
                <span class="font-semibold text-gray-900">{{ $email ?? session('email') ?? 'email Anda' }}</span>
            </p>
        </div>

        {{-- OTP Form Card --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <form action="{{ route('verify.otp') }}" method="POST" class="p-6 space-y-6" id="otpForm">
                @csrf

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

                <input type="hidden" name="email" value="{{ $email ?? session('email') }}">

                {{-- 6 OTP Input Boxes --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3 text-center">
                        Masukkan Kode OTP
                    </label>
                    <div class="flex justify-center gap-2">
                        <input 
                            type="text" 
                            maxlength="1" 
                            pattern="[0-9]"
                            class="otp-input w-12 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            data-index="0"
                            autocomplete="off"
                        >
                        <input 
                            type="text" 
                            maxlength="1" 
                            pattern="[0-9]"
                            class="otp-input w-12 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            data-index="1"
                            autocomplete="off"
                        >
                        <input 
                            type="text" 
                            maxlength="1" 
                            pattern="[0-9]"
                            class="otp-input w-12 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            data-index="2"
                            autocomplete="off"
                        >
                        <input 
                            type="text" 
                            maxlength="1" 
                            pattern="[0-9]"
                            class="otp-input w-12 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            data-index="3"
                            autocomplete="off"
                        >
                        <input 
                            type="text" 
                            maxlength="1" 
                            pattern="[0-9]"
                            class="otp-input w-12 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            data-index="4"
                            autocomplete="off"
                        >
                        <input 
                            type="text" 
                            maxlength="1" 
                            pattern="[0-9]"
                            class="otp-input w-12 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            data-index="5"
                            autocomplete="off"
                        >
                    </div>
                    <p class="mt-2 text-xs text-gray-500 text-center">
                        Kode OTP berlaku selama 10 menit
                    </p>
                </div>

                {{-- Hidden input untuk submit --}}
                <input type="hidden" name="otp" id="otpValue">

                {{-- Submit Button --}}
                <button 
                    type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                >
                    Verifikasi
                </button>

                {{-- Resend OTP --}}
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Tidak menerima kode?
                    </p>
                    <button 
                        type="button"
                        onclick="resendOTP()"
                        id="resendBtn"
                        class="text-sm font-semibold text-red-600 hover:text-red-700 mt-1 disabled:text-gray-400 disabled:cursor-not-allowed"
                    >
                        Kirim Ulang OTP
                    </button>
                    <p id="countdown" class="text-xs text-gray-500 mt-1"></p>
                </div>
            </form>
        </div>

        {{-- Footer Note --}}
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">Catatan Penting:</p>
                    <p class="text-xs">Setelah verifikasi OTP berhasil, akun Anda akan menunggu persetujuan dari admin sebelum dapat digunakan untuk login.</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Success Modal (Popup) --}}
<div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-sm w-full p-8 transform transition-all">
        <div class="text-center">
            {{-- Success Icon --}}
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full border-2 border-gray-200 mb-6">
                <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            
            {{-- Success Message --}}
            <h3 class="text-xl font-semibold text-gray-900 mb-2">OTP Verification Successful</h3>
            <p class="text-sm text-gray-600 mb-1">
                Akun Anda berhasil diverifikasi!
            </p>
            <p class="text-xs text-gray-500">
                Menunggu persetujuan admin untuk dapat login.
            </p>
        </div>
    </div>
</div>

<script>
const inputs = document.querySelectorAll('.otp-input');
const form = document.getElementById('otpForm');
const otpValue = document.getElementById('otpValue');

// Auto focus first input
inputs[0].focus();

inputs.forEach((input, index) => {
    // Only allow numbers
    input.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Auto move to next input
        if (this.value && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
        
        // Update hidden input value
        updateOTPValue();
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
        }
        
        const lastIndex = Math.min(index + pastedData.length, inputs.length - 1);
        inputs[lastIndex].focus();
        
        updateOTPValue();
    });
});

function updateOTPValue() {
    let otp = '';
    inputs.forEach(input => {
        otp += input.value;
    });
    otpValue.value = otp;
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
    inputs.forEach(input => input.value = '');
    inputs[0].focus();
    
    fetch('{{ route("resend.otp") }}', {
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
        alert('Kode OTP baru telah dikirim ke email Anda');
        startCountdown();
    })
    .catch(error => {
        alert('Gagal mengirim OTP. Silakan coba lagi.');
    });
}

function showSuccessModal() {
    document.getElementById('successModal').classList.remove('hidden');
    
    // Auto redirect after 5 seconds
    setTimeout(() => {
        window.location.href = "{{ route('login') }}";
    }, 5000);
}

window.onload = function() {
    startCountdown();
};

form.addEventListener('submit', function(e) {
    if (otpValue.value.length !== 6) {
        e.preventDefault();
        alert('Masukkan 6 digit OTP');
    }
});

// Check if OTP verification successful
@if(session('otp_verified_success'))
    document.addEventListener('DOMContentLoaded', function() {
        showSuccessModal();
    });
@endif
</script>
@endsection