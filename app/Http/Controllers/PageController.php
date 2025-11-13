<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    // FAQ Page
    public function faq()
    {
        return view('FAQ');
    }

    // Kontak Page
    public function kontak()
    {
        return view('kontak');
    }

    // Send Contact Form
    public function sendKontak(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string'
        ]);

        // TODO: Send email (optional)
        // Mail::to('ksr@pmiuhhas.or.id')->send(new ContactMail($validated));

        return redirect()->route('kontak')->with('success', 'Pesan Anda telah terkirim! Kami akan segera menghubungi Anda.');
    }

    // Tentang Kami Page
    public function tentangKami()
    {
        return view('tentang_kami');
    }
}