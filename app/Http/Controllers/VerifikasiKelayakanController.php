<?php
// filepath: app/Http/Controllers/VerifikasiKelayakanController.php

namespace App\Http\Controllers;

use App\Models\VerifikasiKelayakan;
use App\Models\Pendonor;
use App\Models\PendaftaranKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VerifikasiKelayakanController extends Controller
{
    /**
     * Display a listing of verifikasi kelayakan.
     */
    public function index(Request $request)
    {
        try {
            $query = VerifikasiKelayakan::with([
                'pendonor.user',
                'kegiatan',
                'pendaftaran'
            ]);

            // Search functionality
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->whereHas('pendonor.user', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })->orWhereHas('pendonor', function($q) use ($search) {
                    $q->where('golongan_darah', 'like', "%{$search}%");
                });
            }

            // Filter by Golongan Darah
            if ($request->has('golongan_darah') && $request->golongan_darah != '') {
                $query->whereHas('pendonor', function($q) use ($request) {
                    $q->where('golongan_darah', $request->golongan_darah);
                });
            }

            // Filter by Status
            if ($request->has('status') && $request->status != '') {
                $query->where('status_verifikasi', $request->status);
            }

            $verifikasi = $query->latest()->get();
            $totalPermintaan = VerifikasiKelayakan::count();

            return view('dashboard.dev.verifikasi-kelayakan', compact('verifikasi', 'totalPermintaan'));

        } catch (\Exception $e) {
            Log::error('Error in VerifikasiKelayakanController@index: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat data verifikasi');
        }
    }

    /**
     * Show the details of a specific verifikasi.
     */
    public function show($id)
    {
        try {
            $verifikasi = VerifikasiKelayakan::with([
                'pendonor.user',
                'kegiatan',
                'pendaftaran',
                'verifiedBy'
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $verifikasi
            ]);

        } catch (\Exception $e) {
            Log::error('Error in VerifikasiKelayakanController@show: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Data verifikasi tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Approve verifikasi (set as Layak).
     */
    public function approve(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $verifikasi = VerifikasiKelayakan::findOrFail($id);
            
            // Update verifikasi status
            $verifikasi->update([
                'status_verifikasi' => 'Layak',
                'catatan' => $request->catatan ?? 'Memenuhi semua persyaratan donor darah',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);

            // Update status pendaftaran
            if ($verifikasi->pendaftaran) {
                $verifikasi->pendaftaran->update([
                    'status_pendaftaran' => 'Verified'
                ]);
            }

            // Kirim notifikasi ke pendonor (jika service notifikasi sudah ada)
            // NotifikasiService::kirimKeUser(
            //     $verifikasi->pendonor->user_id,
            //     'Verifikasi Kelayakan Disetujui',
            //     "Selamat! Anda dinyatakan layak untuk mengikuti kegiatan donor darah: {$verifikasi->kegiatan->nama_kegiatan}"
            // );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Verifikasi berhasil disetujui. Pendonor dinyatakan LAYAK untuk mendonor.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in VerifikasiKelayakanController@approve: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyetujui verifikasi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject verifikasi (set as Ditolak).
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $verifikasi = VerifikasiKelayakan::findOrFail($id);
            
            // Update verifikasi status
            $verifikasi->update([
                'status_verifikasi' => 'Ditolak',
                'catatan' => $request->catatan ?? 'Tidak memenuhi persyaratan kelayakan donor darah',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);

            // Update status pendaftaran
            if ($verifikasi->pendaftaran) {
                $verifikasi->pendaftaran->update([
                    'status_pendaftaran' => 'Rejected'
                ]);
            }

            // Kirim notifikasi ke pendonor (jika service notifikasi sudah ada)
            // NotifikasiService::kirimKeUser(
            //     $verifikasi->pendonor->user_id,
            //     'Verifikasi Kelayakan Ditolak',
            //     "Maaf, Anda belum dapat mengikuti kegiatan donor darah: {$verifikasi->kegiatan->nama_kegiatan}. Alasan: {$verifikasi->catatan}"
            // );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Verifikasi berhasil ditolak. Pendonor dinyatakan TIDAK LAYAK untuk mendonor.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in VerifikasiKelayakanController@reject: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menolak verifikasi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics for dashboard.
     */
    public function getStatistics()
    {
        try {
            $stats = [
                'total' => VerifikasiKelayakan::count(),
                'menunggu' => VerifikasiKelayakan::menunggu()->count(),
                'layak' => VerifikasiKelayakan::layak()->count(),
                'ditolak' => VerifikasiKelayakan::ditolak()->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Error in VerifikasiKelayakanController@getStatistics: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil statistik'
            ], 500);
        }
    }

    /**
     * Delete verifikasi record.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $verifikasi = VerifikasiKelayakan::findOrFail($id);
            $verifikasi->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data verifikasi berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in VerifikasiKelayakanController@destroy: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}