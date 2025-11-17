@extends('layouts.guest')

@section('title', 'Verifikasi OTP - KSR PMI UNHAS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        {{-- Header --}}
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-ksr-pmi.png') }}" alt="Logo KSR PMI" class="mx-auto h-16 w-16 object-contain mb-4" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2264%22 height=%2264%22 viewBox=%220 0 64 64%22%3E%3Ccircle cx=%2232%22 cy=%2232%22 r=%2232%22 fill=%22%23dc2626%22/%3E%3Cpath d=%22M32 12 L38 28 L54 28 L42 38 L46 54 L32 45 L18 54 L22 38 L10 28 L26 28 Z%22 fill=%22white%22/%3E%3C/svg%3E'">
            <h2 class="text-2xl font-bold text-gray-900">
                OTP Verification
            </h2>
        </div>

        {{-- OTP Form Card --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <form action="{{ route('verify.otp') }}" method="POST" class="p-8 space-y-6" id="otpForm">
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

                {{-- OTP Message --}}
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        An OTP has been sent to
                    </p>
                    <p class="text-sm font-medium text-gray-900 mt-1">
                        {{ session('email') ?? 'XXX-XXX-XXXX' }}
                    </p>
                </div>

                {{-- 4 OTP Input Boxes --}}
                <div class="flex justify-center gap-3">
                    <input 
                        type="text" 
                        maxlength="1" 
                        pattern="[0-9]"
                        class="otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        data-index="0"
                    >
                    <input 
                        type="text" 
                        maxlength="1" 
                        pattern="[0-9]"
                        class="otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        data-index="1"
                    >
                    <input 
                        type="text" 
                        maxlength="1" 
                        pattern="[0-9]"
                        class="otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        data-index="2"
                    >
                    <input 
                        type="text" 
                        maxlength="1" 
                        pattern="[0-9]"
                        class="otp-input w-14 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        data-index="3"
                    >
                </div>

                {{-- Hidden input untuk submit --}}
                <input type="hidden" name="otp" id="otpValue">

                {{-- Resend OTP --}}
                <div class="text-center">
                    <button 
                        type="button"
                        onclick="resendOTP()"
                        id="resendBtn"
                        class="text-sm font-medium text-red-600 hover:text-red-700 disabled:text-gray-400 disabled:cursor-not-allowed"
                    >
                        RESEND OTP
                    </button>
                    <p id="countdown" class="text-xs text-gray-500 mt-1"></p>
                </div>

                {{-- Submit Button --}}
                <button 
                    type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                >
                    Verify & Proceed
                </button>
            </form>
        </div>

        {{-- Back to Login --}}
        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Kembali ke Login
            </a>
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
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Kode OTP baru telah dikirim ke email Anda');
            startCountdown();
        }
    })
    .catch(error => {
        alert('Gagal mengirim OTP. Silakan coba lagi.');
    });
}

window.onload = function() {
    startCountdown();
};

form.addEventListener('submit', function(e) {
    if (otpValue.value.length !== 4) {
        e.preventDefault();
        alert('Masukkan 4 digit OTP');
    }
});
</script>
@endsection