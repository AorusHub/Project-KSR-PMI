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
            $pendonor = auth()->user()->pendonor;
            
            if (!$pendonor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum melengkapi profil pendonor'
                ], 400);
            }

            VerifikasiKelayakan::create([
                'pendonor_id' => $pendonor->pendonor_id,
                'golongan_darah' => $request->golongan_darah ?? $pendonor->golongan_darah,
                'berat_badan' => $request->berat_badan ?? 50,
                'sedang_sakit_demam_batuk_pilek_flu' => $request->input('sedang_sakit_demam_batuk_pilek_flu', 0),
                'konsumsi_obat' => $request->input('konsumsi_obat', 0),
                'riwayat_penyakit_hepatitis_hiv_sifilis' => $request->input('riwayat_penyakit_hepatitis_hiv_sifilis', 0),
                'pernah_ditato_ditindik_diupanat_6bulan' => $request->input('pernah_ditato_ditindik_diupanat_6bulan', 0),
                'sedang_hamil_menyusui_melahirkan_6bulan' => $request->input('sedang_hamil_menyusui_melahirkan_6bulan', 0),
                'menerima_operasi_transfusi_1tahun' => $request->input('menerima_operasi_transfusi_1tahun', 0),
                'ke_daerah_endemis_malaria_1tahun' => $request->input('ke_daerah_endemis_malaria_1tahun', 0),
                'alergi_obat_makanan_transfusi' => $request->input('alergi_obat_makanan_transfusi', 0),
                'status_kelayakan' => 'Menunggu',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Verifikasi berhasil dikirim'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error submit kelayakan:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
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