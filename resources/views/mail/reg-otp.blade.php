{{-- filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\resources\views\emails\reg-otp.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
        }
        .header {
            background-color: #dc2626;
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            margin: -30px -30px 30px -30px;
        }
        .otp-box {
            background-color: white;
            border: 2px dashed #dc2626;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #dc2626;
            letter-spacing: 8px;
            margin: 10px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
        }
        .warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">KSR PMI UNHAS</h1>
            <p style="margin: 5px 0 0 0;">Kode Verifikasi OTP</p>
        </div>

        <h2>Halo, {{ $userName }}!</h2>
        <p>Terima kasih telah mendaftar di KSR PMI UNHAS. Gunakan kode OTP berikut untuk memverifikasi akun Anda:</p>

        <div class="otp-box">
            <p style="margin: 0; color: #6b7280; font-size: 14px;">Kode OTP Anda</p>
            <div class="otp-code">{{ $otpCode }}</div>
            <p style="margin: 0; color: #6b7280; font-size: 12px;">Berlaku selama 10 menit</p>
        </div>

        <div class="warning">
            <strong>⚠️ Penting:</strong>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Jangan bagikan kode ini kepada siapapun</li>
                <li>Kode OTP hanya berlaku selama 10 menit</li>
                <li>Abaikan email ini jika Anda tidak mendaftar</li>
            </ul>
        </div>

        <p>Jika Anda memiliki pertanyaan, silakan hubungi kami.</p>

        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; 2025 KSR PMI UNHAS. All rights reserved.</p>
        </div>
    </div>
</body>
</html>