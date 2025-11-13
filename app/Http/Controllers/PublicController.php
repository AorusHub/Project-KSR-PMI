<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PublicController extends Controller
{
    // Halaman FAQ
    public function faq()
    {
        $faqs = [
            [
                'pertanyaan' => 'Siapa yang boleh donor darah?',
                'jawaban' => 'Setiap orang yang sehat berusia 17-60 tahun dengan berat badan minimal 45 kg dapat mendonorkan darah.'
            ],
            [
                'pertanyaan' => 'Berapa lama proses donor darah?',
                'jawaban' => 'Proses donor darah memakan waktu sekitar 10-15 menit untuk pengambilan darah, total keseluruhan sekitar 30-45 menit termasuk registrasi dan istirahat.'
            ],
            [
                'pertanyaan' => 'Apakah donor darah aman?',
                'jawaban' => 'Ya, donor darah sangat aman. Semua peralatan yang digunakan steril dan sekali pakai, serta dilakukan oleh tenaga medis terlatih.'
            ],
            [
                'pertanyaan' => 'Seberapa sering saya bisa donor darah?',
                'jawaban' => 'Anda dapat mendonorkan darah setiap 2-3 bulan sekali atau maksimal 5 kali dalam setahun untuk pria dan 4 kali untuk wanita.'
            ],
            [
                'pertanyaan' => 'Apa yang harus dipersiapkan sebelum donor darah?',
                'jawaban' => 'Pastikan Anda tidur cukup, makan makanan bergizi, minum air putih yang cukup, dan membawa kartu identitas (KTP/SIM/Paspor).'
            ],
            [
                'pertanyaan' => 'Apakah ada efek samping setelah donor darah?',
                'jawaban' => 'Efek samping ringan seperti pusing atau lemas mungkin terjadi, namun biasanya hilang dalam beberapa jam. Istirahat yang cukup dan konsumsi makanan bergizi akan membantu pemulihan.'
            ],
            [
                'pertanyaan' => 'Apakah saya akan mendapat kompensasi?',
                'jawaban' => 'Donor darah di PMI adalah kegiatan sukarela tanpa kompensasi materi. Namun Anda akan mendapat sertifikat penghargaan dan makanan ringan setelah donor.'
            ],
            [
                'pertanyaan' => 'Bagaimana cara mendaftar donor darah?',
                'jawaban' => 'Anda bisa mendaftar melalui website ini dengan membuat akun, kemudian pilih jadwal kegiatan donor darah yang tersedia dan lakukan pendaftaran online.'
            ],
        ];

        return view('public.faq', compact('faqs'));
    }

    // Halaman Kontak
    public function kontak()
    {
        return view('public.kontak');
    }

    // Kirim Pesan Kontak
    public function sendKontak(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string|min:10',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'subjek.required' => 'Subjek wajib diisi',
            'pesan.required' => 'Pesan wajib diisi',
            'pesan.min' => 'Pesan minimal 10 karakter',
        ]);

        // Simpan ke database atau kirim email (opsional)
        // Untuk sementara hanya redirect dengan pesan sukses
        
        return redirect()->route('kontak')->with('success', 'Pesan Anda berhasil dikirim! Tim kami akan segera menghubungi Anda.');
    }

    // Halaman Tentang Kami
    public function tentangKami()
    {
        return view('public.tentang-kami');
    }
}