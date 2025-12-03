<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Http\Controllers\StokDarahController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokDarah;
use Illuminate\Support\Facades\Auth;

class StokDarahController extends Controller
{
    /**
     * ✅ Tampilkan halaman stok darah (Admin & Staf only)
     */
    public function index()
    {
        // Authorization: Hanya admin dan staf yang bisa akses
        if (!in_array(Auth::user()->role, ['admin', 'staf'])) {
            abort(403, 'Unauthorized action.');
        }

        // Data stok darah per golongan
        $stokDarah = [
            'A+' => StokDarah::where('golongan_darah', 'A+')->sum('jumlah_kantong') ?? 0,
            'B+' => StokDarah::where('golongan_darah', 'B+')->sum('jumlah_kantong') ?? 0,
            'O+' => StokDarah::where('golongan_darah', 'O+')->sum('jumlah_kantong') ?? 0,
            'AB+' => StokDarah::where('golongan_darah', 'AB+')->sum('jumlah_kantong') ?? 0,
            'A-' => StokDarah::where('golongan_darah', 'A-')->sum('jumlah_kantong') ?? 0,
            'B-' => StokDarah::where('golongan_darah', 'B-')->sum('jumlah_kantong') ?? 0,
            'O-' => StokDarah::where('golongan_darah', 'O-')->sum('jumlah_kantong') ?? 0,
            'AB-' => StokDarah::where('golongan_darah', 'AB-')->sum('jumlah_kantong') ?? 0,
        ];

        // Hitung perubahan bulan ini
        $perubahanBulanIni = [
            'A+' => $this->hitungPerubahan('A+'),
            'B+' => $this->hitungPerubahan('B+'),
            'O+' => $this->hitungPerubahan('O+'),
            'AB+' => $this->hitungPerubahan('AB+'),
            'A-' => $this->hitungPerubahan('A-'),
            'B-' => $this->hitungPerubahan('B-'),
            'O-' => $this->hitungPerubahan('O-'),
            'AB-' => $this->hitungPerubahan('AB-'),
        ];

        return view('dashboard.dev.stok-darah', compact('stokDarah', 'perubahanBulanIni'));
    }

    /**
     * Hitung perubahan stok bulan ini
     */
    private function hitungPerubahan($golongan)
    {
        $bulanIni = StokDarah::where('golongan_darah', $golongan)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('jumlah_kantong');

        return $bulanIni ?? 0;
    }

    /**
     * ✅ Update stok darah (Admin & Staf only)
     */
    public function update(Request $request)
    {
        // Authorization
        if (!in_array(Auth::user()->role, ['admin', 'staf'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        $validated = $request->validate([
            'golongan_darah' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'jumlah_kantong' => 'required|integer',
            'keterangan' => 'nullable|string'
        ]);

        try {
            StokDarah::create([
                'golongan_darah' => $validated['golongan_darah'],
                'jumlah_kantong' => $validated['jumlah_kantong'],
                'keterangan' => $validated['keterangan'] ?? 'Update manual',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Stok darah berhasil diupdate!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}