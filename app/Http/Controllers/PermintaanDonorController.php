<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Http\Controllers\PermintaanDonorController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermintaanDonor;
use App\Models\StokDarah;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\PermintaanDonorCreated;

class PermintaanDonorController extends Controller
{
    /**
     * Tampilkan formulir permintaan darah (untuk pendonor)
     */
    public function create()
    {
        return view('dashboard.pendonor.formulir-permintaan-donor-darah');
    }

    /**
     * Simpan data permintaan darah (dari pendonor)
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'gol_darah' => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'riwayat' => 'nullable|string|max:1000',
            'tempat_rawat' => 'required|string|max:255',
            'jenis_permintaan' => 'required|string',
            'jumlah_kantong' => 'required|integer|min:1|max:10',
            'tingkat_urgensi' => 'required|string',
            'nama_kontak' => 'required|string|max:255',
            'no_hp' => 'required|string|min:10|max:15',
            'hubungan' => 'required|string|max:100',
            'tanggal_hari' => 'required|date',
        ]);

        try {
            // Generate nomor pelacakan yang unik
            do {
                $nomorPelacakan = 'REQ' . now()->format('ymd') . strtoupper(Str::random(5));
            } while (PermintaanDonor::where('nomor_pelacakan', $nomorPelacakan)->exists());

            // Simpan data ke database dengan nomor_pelacakan
            $permintaan = PermintaanDonor::create([
                'nomor_pelacakan' => $nomorPelacakan,
                'tanggal_hari' => $validated['tanggal_hari'],
                'nama_pasien' => $validated['nama_pasien'],
                'gol_darah' => $validated['gol_darah'],
                'jumlah_kantong' => $validated['jumlah_kantong'],
                'riwayat' => $validated['riwayat'],
                'tempat_rawat' => $validated['tempat_rawat'],
                'jenis_permintaan' => $validated['jenis_permintaan'],
                'tingkat_urgensi' => $validated['tingkat_urgensi'],
                'nama_kontak' => $validated['nama_kontak'],
                'no_hp' => $validated['no_hp'],
                'hubungan' => $validated['hubungan'],
                'kontak_keluarga' => $validated['no_hp'],
                'status_permintaan' => 'Pending',
            ]);
            event(new \App\Events\PermintaanDonorCreated($permintaan));

            // Return JSON response untuk AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permintaan donor darah berhasil dikirim!',
                    'nomor_pelacakan' => $nomorPelacakan,
                    'permintaan_id' => $permintaan->permintaan_id
                ]);
            }

            return redirect()->route('pendonor.dashboard')
                ->with('success', 'Permintaan donor darah berhasil dikirim!')
                ->with('nomor_pelacakan', $nomorPelacakan);

        } catch (\Exception $e) {
            \Log::error('Error menyimpan permintaan donor:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * ✅ Tampilkan daftar permintaan donor (untuk admin & staff)
     */
    public function managemenIndex(Request $request)
    {
        // ✅ Authorization: Hanya admin dan staff yang bisa akses
        if (!in_array(Auth::user()->role, ['admin', 'staf'])) {
            abort(403, 'Unauthorized action.');
        }

        $query = PermintaanDonor::query();

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $query->where('status_permintaan', $request->status);
        }

        // Filter berdasarkan tingkat urgensi
        if ($request->filled('urgensi')) {
            $query->where('tingkat_urgensi', $request->urgensi);
        }

        // Search berdasarkan nama pasien atau golongan darah
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pasien', 'like', "%{$search}%")
                  ->orWhere('gol_darah', 'like', "%{$search}%")
                  ->orWhere('nomor_pelacakan', 'like', "%{$search}%");
            });
        }

        // Hitung statistik
        $totalPermintaan = PermintaanDonor::count();
        $darurat = PermintaanDonor::where('tingkat_urgensi', 'Sangat Mendesak')->count();
        $belumTerpenuhi = PermintaanDonor::where('status_permintaan', 'Pending')->count();
        $diproses = PermintaanDonor::where('status_permintaan', 'Approved')->count();
        $terpenuhi = PermintaanDonor::where('status_permintaan', 'Completed')->count();

        // Get paginated data
        $permintaan = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('dashboard.dev.managemen-permintaan-darurat', compact(
            'permintaan',
            'totalPermintaan',
            'darurat',
            'belumTerpenuhi',
            'diproses',
            'terpenuhi'
        ));
    }

    /**
     * ✅ Tampilkan detail permintaan (untuk admin & staff)
     */
    public function managemenShow($id)
    {
        // ✅ Authorization: Hanya admin dan staff yang bisa akses
        if (!in_array(Auth::user()->role, ['admin', 'staf'])) {
            abort(403, 'Unauthorized action.');
        }

        $permintaan = PermintaanDonor::findOrFail($id);
        return view('dashboard.dev.detail-permintaan-darurat', compact('permintaan'));
    }

    /**
     * ✅ Get detail permintaan untuk modal (AJAX)
     */
    public function getDetail($id)
    {
        try {
            $permintaan = PermintaanDonor::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $permintaan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    /**
     * ✅ Cek stok darah sebelum proses
     */
    public function cekStok(Request $request)
    {
        $validated = $request->validate([
            'golongan_darah' => 'required|string',
            'jenis_darah' => 'required|string',
            'jumlah_kantong' => 'required|integer'
        ]);

        // Hitung total stok yang tersedia
        $stokTersedia = StokDarah::where('golongan_darah', $validated['golongan_darah'])
            ->where('jenis_darah', $validated['jenis_darah'])
            ->sum('jumlah_kantong');

        return response()->json([
            'stok_cukup' => $stokTersedia >= $validated['jumlah_kantong'],
            'stok_tersedia' => $stokTersedia,
            'jumlah_dibutuhkan' => $validated['jumlah_kantong']
        ]);
    }

    /**
     * ✅ Proses permintaan dan kurangi stok
     */
    public function prosesPermintaan(Request $request, $id)
    {
        // Authorization
        if (!in_array(Auth::user()->role, ['admin', 'staf'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        $validated = $request->validate([
            'golongan_darah' => 'required|string',
            'jenis_darah' => 'required|string',
            'jumlah_kantong' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            // Update status permintaan
            $permintaan = PermintaanDonor::findOrFail($id);
            $permintaan->status_permintaan = 'Completed';
            $permintaan->save();

            // Kurangi stok darah (catat sebagai pengurangan)
            StokDarah::create([
                'golongan_darah' => $validated['golongan_darah'],
                'jenis_darah' => $validated['jenis_darah'],
                'jumlah_kantong' => -$validated['jumlah_kantong'], // Negative value untuk pengurangan
                'keterangan' => "Digunakan untuk permintaan {$permintaan->nomor_pelacakan} - {$permintaan->nama_pasien}",
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Permintaan berhasil diproses dan stok darah telah dikurangi'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ Update status permintaan (untuk admin & staff)
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            // ✅ Log untuk debug
            \Log::info('Update Status Request', [
                'id' => $id,
                'request_data' => $request->all(),
                'user_role' => Auth::user()->role ?? 'guest'
            ]);

            // ✅ Authorization: Hanya admin dan staff yang bisa akses
            if (!in_array(Auth::user()->role, ['admin', 'staf'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action.'
                ], 403);
            }

            // ✅ UPDATE: Tambah "Failed" di validasi
            try {
                $validated = $request->validate([
                    'status_permintaan' => 'required|in:Pending,Approved,Completed,Rejected,Requesting,Responded,Failed'
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                \Log::error('Validation error:', ['errors' => $e->errors()]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }

            $permintaan = PermintaanDonor::findOrFail($id);
            
            // ✅ Log sebelum update
            \Log::info('Before update', [
                'id' => $id,
                'old_status' => $permintaan->status_permintaan
            ]);
            
            $permintaan->status_permintaan = $validated['status_permintaan'];
            $permintaan->save();
            
            // ✅ Log setelah update
            \Log::info('After update', [
                'id' => $id,
                'new_status' => $permintaan->status_permintaan
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diupdate!',
                'data' => [
                    'id' => $permintaan->permintaan_id,
                    'status' => $permintaan->status_permintaan
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Permintaan not found:', ['id' => $id]);
            
            return response()->json([
                'success' => false,
                'message' => 'Permintaan tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            \Log::error('Error update status permintaan:', [
                'id' => $id,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * LAMA: Tampilkan daftar permintaan donor (generic)
     */
    public function index()
    {
        $permintaan = PermintaanDonor::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.permintaan-donor.index', compact('permintaan'));
    }

    /**
     * LAMA: Tampilkan detail permintaan (generic)
     */
    public function show($id)
    {
        $permintaan = PermintaanDonor::findOrFail($id);
        return view('dashboard.permintaan-donor.detail', compact('permintaan'));
    }

    /**
     * ✅ Tampilkan daftar permintaan darah darurat (untuk pendonor)
     */
    public function darahDarurat(Request $request)
    {
        $search = $request->input('search');
        
        // ✅ Query permintaan darah dengan status "Requesting" 
        $permintaanDarurat = PermintaanDonor::where('status_permintaan', 'Requesting')
            ->when($search, function($query) use ($search) {
                $query->where('nama_pasien', 'like', "%{$search}%")
                    ->orWhere('gol_darah', 'like', "%{$search}%")
                    ->orWhere('nomor_pelacakan', 'like', "%{$search}%");
            })
            ->orderByRaw("FIELD(tingkat_urgensi, 'Sangat Mendesak', 'Mendesak', 'Normal')")
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('dashboard.pendonor.permintaan-darah', compact('permintaanDarurat'));
    }

    /**
     * ✅ Respond permintaan darah darurat (pendonor)
     */
    public function respondDarurat(Request $request, $id)
    {
        try {
            $permintaan = PermintaanDonor::findOrFail($id);
            $pendonor = auth()->user()->pendonor;
            
            if (!$pendonor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses sebagai pendonor'
                ], 403);
            }
            
            // ✅ CEK apakah permintaan ini sudah direspond
            if ($permintaan->nama_pendonor_respond) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permintaan ini sudah direspons oleh pendonor lain'
                ], 400);
            }
            
            // ✅ Validasi input
            $validated = $request->validate([
                'nama_pendonor' => 'required|string|max:255',
                'tgl_lahir' => 'required|date',
                'gol_darah' => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
                'no_telp' => 'required|string|min:10|max:15'
            ]);
            
            // ✅ UPDATE permintaan dengan data pendonor yang merespons
            $permintaan->update([
                'nama_pendonor_respond' => $validated['nama_pendonor'],
                'tgl_lahir_pendonor' => $validated['tgl_lahir'],
                'gol_darah_pendonor' => $validated['gol_darah'],
                'no_telp_pendonor' => $validated['no_telp'],
                'tanggal_respond' => now(),
                'status_permintaan' => 'Responded' // Update status
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Terima kasih! Respons Anda telah berhasil dikirim. Tim kami akan segera menghubungi Anda.'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            \Log::error('Error respond permintaan darurat:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}