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
        // ✅ Authorization: Hanya admin dan staff yang bisa akses
        if (!in_array(Auth::user()->role, ['admin', 'staf'])) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action.'
                ], 403);
            }
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status_permintaan' => 'required|in:Pending,Approved,Completed,Rejected'
        ]);

        try {
            $permintaan = PermintaanDonor::findOrFail($id);
            $permintaan->update([
                'status_permintaan' => $validated['status_permintaan']
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status berhasil diupdate!'
                ]);
            }

            return back()->with('success', 'Status permintaan berhasil diupdate!');

        } catch (\Exception $e) {
            \Log::error('Error update status permintaan:', [
                'message' => $e->getMessage()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengupdate status.'
                ], 500);
            }

            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengupdate status.']);
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

    public function darahDarurat()
    {
        $search = request('search');
        
        $permintaanDarurat = PermintaanDarah::where('status', 'Darurat')
            ->when($search, function($query) use ($search) {
                $query->where('nama_pasien', 'like', "%{$search}%")
                    ->orWhere('golongan_darah', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);
        
        return view('donor-darurat.index', compact('permintaanDarurat'));
    }

    public function respondDarurat(Request $request, $id)
    {
        try {
            $permintaan = PermintaanDarah::findOrFail($id);
            $pendonorId = auth()->user()->pendonor->pendonor_id;
            
            // Cek sudah respond atau belum
            $sudahRespond = $permintaan->responses()
                ->where('pendonor_id', $pendonorId)
                ->exists();
            
            if ($sudahRespond) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah merespons permintaan ini'
                ], 400);
            }
            
            // Simpan response
            $permintaan->responses()->create([
                'pendonor_id' => $pendonorId,
                'status' => 'Bersedia',
                'tanggal_response' => now()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Terima kasih! Respons Anda telah dikirim'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}