<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Http\Controllers\VerifikasiKelayakanController.php

namespace App\Http\Controllers;

use App\Models\VerifikasiKelayakan;
use Illuminate\Http\Request;

class VerifikasiKelayakanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $filterDarah = $request->filter_darah;
        
        $verifikasi = VerifikasiKelayakan::with(['pendonor', 'verifiedBy'])
            ->when($search, function($query) use ($search) {
                $query->whereHas('pendonor', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('golongan_darah', 'like', "%{$search}%");
                });
            })
            ->when($filterDarah, function($query) use ($filterDarah) {
                $query->whereHas('pendonor', function($q) use ($filterDarah) {
                    $q->where('golongan_darah', $filterDarah);
                });
            })
            ->latest()
            ->paginate(10);
        
        return view('dashboard.dev.verifikasi-kelayakan', compact('verifikasi'));
    }

    // ✅ TAMBAHKAN METHOD INI - Halaman Form Cek Kelayakan (untuk Pendonor)
    public function cekKelayakan()
    {
        return view('dashboard.pendonor.cek-kelayakan-donor');
    }

    // ✅ TAMBAHKAN METHOD INI - Submit Form Cek Kelayakan (untuk Pendonor)
    public function submitKelayakan(Request $request)
    {
        try {
            $request->validate([
                'berat_badan' => 'required|numeric|min:40|max:200',
                'hemoglobin' => 'required|numeric|min:8|max:20',
                'tekanan_darah_sistol' => 'required|numeric|min:80|max:200',
                'tekanan_darah_diastol' => 'required|numeric|min:50|max:150',
            ]);

            $pendonor = auth()->user()->pendonor;
            
            if (!$pendonor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum melengkapi profil pendonor'
                ], 400);
            }

            VerifikasiKelayakan::create([
                'pendonor_id' => $pendonor->pendonor_id,
                'berat_badan' => $request->berat_badan,
                'tekanan_darah_sistol' => $request->tekanan_darah_sistol,
                'tekanan_darah_diastol' => $request->tekanan_darah_diastol,
                'hemoglobin' => $request->hemoglobin,
                'suhu_tubuh' => $request->suhu_tubuh,
                'sedang_sakit' => $request->input('sedang_sakit', 0),
                'sedang_hamil' => $request->input('sedang_hamil', 0),
                'sedang_menyusui' => $request->input('sedang_menyusui', 0),
                'sedang_menstruasi' => $request->input('sedang_menstruasi', 0),
                'riwayat_penyakit_menular' => $request->input('riwayat_penyakit_menular', 0),
                'konsumsi_obat' => $request->input('konsumsi_obat', 0),
                'minum_alkohol_24jam' => $request->input('minum_alkohol_24jam', 0),
                'tato_tindik_6bulan' => $request->input('tato_tindik_6bulan', 0),
                'operasi_1tahun' => $request->input('operasi_1tahun', 0),
                'transfusi_1tahun' => $request->input('transfusi_1tahun', 0),
                'keterangan_tambahan' => $request->keterangan_tambahan,
                'status_kelayakan' => 'Menunggu',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Verifikasi berhasil dikirim'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function approve(Request $request, $id)
    {
        try {
            $verifikasi = VerifikasiKelayakan::findOrFail($id);
            
            $verifikasi->update([
                'status_kelayakan' => 'Layak',
                'catatan_petugas' => $request->catatan,
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Verifikasi berhasil disetujui'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reject(Request $request, $id)
    {
        try {
            $verifikasi = VerifikasiKelayakan::findOrFail($id);
            
            $verifikasi->update([
                'status_kelayakan' => 'Tidak Layak',
                'catatan_petugas' => $request->catatan,
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Verifikasi ditolak'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}