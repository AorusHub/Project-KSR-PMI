<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Http\Controllers\PermintaanDonorController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermintaanDonor;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
     * ✅ BARU: Tampilkan daftar permintaan donor (untuk admin & staff)
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
        $belumTerpenuhi = PermintaanDonor::where('status_permintaan', 'Pending')->count();
        $diproses = PermintaanDonor::where('status_permintaan', 'Approved')->count();
        $terpenuhi = PermintaanDonor::where('status_permintaan', 'Completed')->count();

        // Get paginated data
        $permintaan = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('dashboard.dev.managemen-permintaan-darurat', compact(
            'permintaan',
            'totalPermintaan',
            'belumTerpenuhi',
            'diproses',
            'terpenuhi'
        ));
    }

    /**
     * ✅ BARU: Tampilkan detail permintaan (untuk admin & staff)
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
     * ✅ BARU: Update status permintaan (untuk admin & staff)
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
}