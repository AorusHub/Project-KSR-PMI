<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DonasiDarah;
use App\Models\KegiatanDonor;
use App\Models\Pendonor;
use App\Models\StokDarah;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DonasiDarahController extends Controller
{
    public function partisipan($kegiatan_id)
    {
        // Cek role
        if (!in_array(Auth::user()->role, ['admin', 'staf'])) {
            abort(403, 'Unauthorized action.');
        }

        $kegiatan = KegiatanDonor::findOrFail($kegiatan_id);
        
        $now = Carbon::now();
        $tanggalKegiatan = Carbon::parse($kegiatan->getAttributes()['tanggal'])->startOfDay();
        $waktuSelesai = Carbon::parse($kegiatan->waktu_selesai);
        
        $kegiatanSelesai = $tanggalKegiatan->setTimeFrom($waktuSelesai);
        
        if ($now->greaterThan($kegiatanSelesai)) {
            DonasiDarah::where('kegiatan_id', $kegiatan_id)
                ->where('status_donasi', 'Terdaftar')
                ->update(['status_donasi' => 'Dibatalkan']);
        }

        $partisipans = DonasiDarah::where('kegiatan_id', $kegiatan_id)
            ->whereHas('pendonor.user')
            ->with('pendonor.user')
            ->paginate(10);

        return view('dashboard.dev.partisipan-kegiatan', compact('kegiatan', 'partisipans'));
    }

    // ✅ UBAH PARAMETER DARI $donasi_id JADI $id atau pastikan route pakai {donasi_id}

    public function updateStatus(Request $request, $id)
    {
        \Log::info('========================================');
        \Log::info('MULAI UPDATE STATUS DONASI');
        \Log::info('Donasi ID dari URL: ' . $id);
        \Log::info('Request Method: ' . $request->method());
        \Log::info('Request Data: ', $request->all());

        try {
            // Validasi jenis darah
            $validated = $request->validate([
                'jenis_darah' => 'required|in:Darah Lengkap (Whole Blood),Packed Red Cells (PRC),Trombosit (TC),Plasma'
            ]);

            \Log::info('Validasi berhasil: ', $validated);

            DB::beginTransaction();

            // Cek apakah ID valid
            if (!$id || $id === 'null') {
                throw new \Exception('Donasi ID tidak valid: ' . $id);
            }

            // Ambil data donasi
            $donasi = DonasiDarah::with('pendonor.user', 'kegiatan')->findOrFail($id);
            
            \Log::info('Data donasi SEBELUM update:', [
                'donasi_id' => $donasi->donasi_id,
                'pendonor' => $donasi->pendonor->user->nama ?? 'N/A',
                'status_lama' => $donasi->status_donasi,
            ]);

            // ✅ UPDATE STATUS DAN JENIS DARAH
            $donasi->update([
                'status_donasi' => 'Berhasil',
                'jenis_darah' => $validated['jenis_darah'],
            ]);

            $donasi->refresh();

            \Log::info('Data donasi SETELAH update:', [
                'status_baru' => $donasi->status_donasi,
                'jenis_darah_baru' => $donasi->jenis_darah,
            ]);

            // Tambah stok darah
            $golonganDarah = $donasi->pendonor->golongan_darah;
            $jenisDarah = $validated['jenis_darah'];

            StokDarah::create([
                'golongan_darah' => $golonganDarah,
                'jenis_darah' => $jenisDarah,
                'jumlah_kantong' => 1,
                'keterangan' => 'Donasi dari ' . $donasi->pendonor->user->nama . ' - ' . ($donasi->kegiatan->nama_kegiatan ?? 'Donasi Langsung'),
            ]);

            DB::commit();
            \Log::info('Transaction COMMIT SUCCESS');

            return redirect()->back()->with('success', 'Status donasi berhasil diperbarui! Stok darah bertambah.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            \Log::error('VALIDATION ERROR:', $e->errors());
            return redirect()->back()->with('error', 'Jenis darah harus dipilih!');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollback();
            \Log::error('MODEL NOT FOUND - Donasi ID: ' . $id);
            return redirect()->back()->with('error', 'Data donasi tidak ditemukan!');
            
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('EXCEPTION ERROR: ' . $e->getMessage());
            \Log::error('Trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function search(Request $request, $kegiatan_id)
    {
        // Cek role
        if (!in_array(Auth::user()->role, ['admin', 'staf'])) {
            abort(403, 'Unauthorized action.');
        }

        $kegiatan = KegiatanDonor::findOrFail($kegiatan_id);
        
        $now = Carbon::now();
        $tanggalKegiatan = Carbon::parse($kegiatan->getAttributes()['tanggal'])->startOfDay();
        $waktuSelesai = Carbon::parse($kegiatan->waktu_selesai);
        
        $kegiatanSelesai = $tanggalKegiatan->setTimeFrom($waktuSelesai);
        
        if ($now->greaterThan($kegiatanSelesai)) {
            DonasiDarah::where('kegiatan_id', $kegiatan_id)
                ->where('status_donasi', 'Terdaftar')
                ->update(['status_donasi' => 'Dibatalkan']);
        }
        
        $search = $request->input('search');
        
        $partisipans = DonasiDarah::where('kegiatan_id', $kegiatan_id)
            ->whereHas('pendonor.user')
            ->with('pendonor.user')
            ->when($search, function($query) use ($search) {
                $query->whereHas('pendonor.user', function($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%");
                });
            })
            ->paginate(10);

        return view('dashboard.dev.partisipan-kegiatan', compact('kegiatan', 'partisipans', 'search'));
    }
}