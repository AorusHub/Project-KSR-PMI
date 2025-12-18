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
use App\Http\Controllers\NotifikasiController;

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
        if (!in_array(Auth::user()->role, ['admin', 'staf'])) {
            abort(403, 'Unauthorized action.');
        }

        $query = PermintaanDonor::with('responPendonor'); // ✅ EAGER LOAD

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $query->where('status_permintaan', $request->status);
        }

        // Filter berdasarkan tingkat urgensi
        if ($request->filled('urgensi')) {
            $query->where('tingkat_urgensi', $request->urgensi);
        }

        // Search
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

        // ✅ Get paginated data WITH RELATION
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
        
        // ✅ AMBIL respon_pendonor
        $responPendonor = DB::table('respon_pendonor')
            ->where('permintaan_id', $id)
            ->where('status', 'pending')
            ->select('id', 'nama_pendonor', 'tgl_lahir', 'gol_darah', 'no_telp')
            ->get();
        
        \Log::info('Get Detail Response:', [
            'permintaan_id' => $id,
            'status' => $permintaan->status_permintaan,
            'respon_count' => $responPendonor->count(),
            'respon_data' => $responPendonor->toArray()
        ]);
        
        return response()->json([
            'success' => true,
            'data' => [
                'permintaan_id' => $permintaan->permintaan_id,
                'nomor_pelacakan' => $permintaan->nomor_pelacakan,
                'nama_pasien' => $permintaan->nama_pasien,
                'gol_darah' => $permintaan->gol_darah,
                'jumlah_kantong' => $permintaan->jumlah_kantong,
                'responden' => $permintaan->responden,
                'darah_didapat' => $permintaan->darah_didapat,
                'tempat_rawat' => $permintaan->tempat_rawat,
                'riwayat' => $permintaan->riwayat,
                'jenis_permintaan' => $permintaan->jenis_permintaan,
                'tingkat_urgensi' => $permintaan->tingkat_urgensi,
                'status_permintaan' => $permintaan->status_permintaan,
                'nama_kontak' => $permintaan->nama_kontak,
                'no_hp' => $permintaan->no_hp,
                'hubungan' => $permintaan->hubungan,
                'created_at' => $permintaan->created_at,
                'pendonor_merespons' => $responPendonor->toArray(), // ✅ INI YANG PENTING
            ]
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error getDetail:', ['message' => $e->getMessage()]);
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
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

    public function updateStatusToRequesting($id)
{
    try {
        DB::beginTransaction();
        
        $permintaan = PermintaanDonor::findOrFail($id);
        $permintaan->status_permintaan = 'Requesting';
        $permintaan->save();
        
        // ✅ AMBIL respon_pendonor
        $responPendonor = DB::table('respon_pendonor')
            ->where('permintaan_id', $id)
            ->where('status', 'pending')
            ->select('id', 'nama_pendonor', 'tgl_lahir', 'gol_darah', 'no_telp')
            ->get();
        
        DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diupdate ke Requesting',
            'pendonor_merespons' => $responPendonor->toArray() // ✅ INI YANG PENTING
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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

            // ✅ Validasi (sudah include "Failed")
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
            
            // ✅ Simpan status lama untuk pengecekan
            $oldStatus = $permintaan->status_permintaan;
            
            // ✅ Log sebelum update
            \Log::info('Before update', [
                'id' => $id,
                'old_status' => $oldStatus
            ]);
            
            // ✅ Update status
            $permintaan->status_permintaan = $validated['status_permintaan'];
            $permintaan->save();
            
            // ✅ Log setelah update
            \Log::info('After update', [
                'id' => $id,
                'new_status' => $permintaan->status_permintaan
            ]);

            // ✅ JIKA STATUS JADI "REQUESTING", AMBIL DATA PENDONOR YANG MERESPONS
            $pendonorMerespons = [];
            if ($validated['status_permintaan'] === 'Requesting') {
                // Query pendonor yang sudah respond ke permintaan ini
                $pendonorMerespons = PermintaanDonor::where('permintaan_id', $id)
                    ->whereNotNull('nama_pendonor_respond')
                    ->select(
                        'permintaan_id as id',
                        'nama_pendonor_respond as nama',
                        'gol_darah_pendonor as golongan_darah',
                        'tgl_lahir_pendonor as tanggal_lahir',
                        'no_telp_pendonor as no_telepon',
                        'tanggal_respond'
                    )
                    ->get()
                    ->toArray();

                // ✅ Kirim notifikasi ke pendonor jika permintaan mendesak
                if ($oldStatus !== 'Requesting' && in_array($permintaan->tingkat_urgensi, ['Mendesak', 'Sangat Mendesak'])) {
                    \Log::info('Sending notification to donors', ['permintaan_id' => $id]);
                    
                    // Kirim notifikasi (uncomment jika NotifikasiController sudah ready)
                    // NotifikasiController::sendRequestingToDonor($permintaan);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diupdate!',
                'data' => [
                    'id' => $permintaan->permintaan_id,
                    'status' => $permintaan->status_permintaan,
                    'notification_sent' => ($oldStatus !== 'Requesting' && $validated['status_permintaan'] === 'Requesting')
                ],
                'pendonor_merespons' => $pendonorMerespons // ✅ KIRIM DATA PENDONOR KE FRONTEND
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
        $query = PermintaanDonor::query()
            ->whereIn('status_permintaan', ['Requesting']);

        // ✅ FILTER: Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pasien', 'like', '%' . $search . '%')
                ->orWhere('gol_darah', 'like', '%' . $search . '%')
                ->orWhere('nomor_pelacakan', 'like', '%' . $search . '%');
            });
        }

        // ✅ FILTER: Tingkat Urgensi
        if ($request->filled('tingkat_urgensi')) {
            $query->where('tingkat_urgensi', $request->tingkat_urgensi);
        }

        // ✅ SORTING
        $query->orderByRaw("FIELD(tingkat_urgensi, 'Sangat Mendesak', 'Mendesak', 'Normal')")
            ->orderBy('created_at', 'desc');

        // ✅ PAGINATION (TANPA JOIN, langsung ambil kolom responden)
        $permintaanDarurat = $query->paginate(10)->withQueryString();
        
        return view('dashboard.pendonor.permintaan-darah', compact('permintaanDarurat'));
    }

    /**
     * ✅ Respond permintaan darah darurat (pendonor)
     */
    
    public function respondDarurat(Request $request, $id)
    {
        try {
            $permintaan = PermintaanDonor::findOrFail($id);
            $user = auth()->user();
            
            // ✅ CEK apakah responden sudah penuh
            if ($permintaan->responden >= $permintaan->jumlah_kantong) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permintaan ini sudah terpenuhi (responden penuh)'
                ], 400);
            }
            
            // ✅ CEK apakah user sudah pernah respond ke permintaan ini
            $sudahRespond = DB::table('respon_pendonor')
                ->where('permintaan_id', $id)
                ->where('user_id', $user->id)
                ->exists();
                
            if ($sudahRespond) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah merespons permintaan ini sebelumnya'
                ], 400);
            }
            
            // ✅ Validasi - Data sudah auto-fill dari user profile
            $validated = $request->validate([
                'nama_pendonor' => 'required|string|max:255',
                'tgl_lahir' => 'required|date',
                'gol_darah' => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
                'no_telp' => 'required|string|min:10|max:15'
            ]);
            
            DB::beginTransaction();
            
            try {
                // ✅ SIMPAN data respons ke tabel respon_pendonor (tracking siapa yang respond)
                DB::table('respon_pendonor')->insert([
                    'permintaan_id' => $id,
                    'user_id' => $user->user_id,
                    'pendonor_id' => $user->pendonor->pendonor_id ?? null,
                    'nama_pendonor' => $validated['nama_pendonor'],
                    'tgl_lahir' => $validated['tgl_lahir'],
                    'gol_darah' => $validated['gol_darah'],
                    'no_telp' => $validated['no_telp'],
                    'status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                // ✅ INCREMENT kolom responden (+1)
                $permintaan->increment('responden');
                
                // ✅ AUTO UPDATE STATUS jika responden = jumlah_kantong
                if ($permintaan->responden >= $permintaan->jumlah_kantong) {
                    $permintaan->update(['status_permintaan' => 'Responded']);
                }
                
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Terima kasih! Respons Anda telah berhasil dikirim.',
                    'responden_count' => $permintaan->responden,
                    'status' => $permintaan->status_permintaan
                ]);
                
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
            
        } catch (\Exception $e) {
            \Log::error('Error respond permintaan darurat:', [
                'message' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showDetail($id)
    {
        try {
            $permintaan = PermintaanDonor::findOrFail($id);
            
            // ✅ FIX: Sesuaikan nama kolom dengan database Anda
            $pendonorMerespons = [];
            if (in_array($permintaan->status_permintaan, ['Requesting', 'Responded'])) {
                $pendonorMerespons = DB::table('respon_pendonor')
                    ->where('permintaan_id', $id)
                    ->where('status', 'pending') // ✅ Filter yang status masih pending
                    ->select(
                        'id',
                        'nama_pendonor',  // ✅ Kolom sudah benar
                        'tgl_lahir',      // ✅ Kolom sudah benar
                        'gol_darah',      // ✅ Kolom sudah benar
                        'no_telp'         // ✅ Kolom sudah benar
                    )
                    ->get()
                    ->toArray();
            }
            
            // ✅ Debug log
            \Log::info('Show Detail Debug:', [
                'permintaan_id' => $id,
                'status' => $permintaan->status_permintaan,
                'pendonor_count' => count($pendonorMerespons),
                'pendonor_data' => $pendonorMerespons
            ]);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'permintaan_id' => $permintaan->permintaan_id,
                    'nomor_pelacakan' => $permintaan->nomor_pelacakan,
                    'nama_pasien' => $permintaan->nama_pasien,
                    'gol_darah' => $permintaan->gol_darah,
                    'jumlah_kantong' => $permintaan->jumlah_kantong,
                    'responden' => $permintaan->responden,
                    'darah_didapat' => $permintaan->darah_didapat,
                    'tempat_rawat' => $permintaan->tempat_rawat,
                    'riwayat' => $permintaan->riwayat,
                    'jenis_permintaan' => $permintaan->jenis_permintaan,
                    'tingkat_urgensi' => $permintaan->tingkat_urgensi,
                    'status_permintaan' => $permintaan->status_permintaan,
                    'nama_kontak' => $permintaan->nama_kontak,
                    'no_hp' => $permintaan->no_hp,
                    'hubungan' => $permintaan->hubungan,
                    'created_at' => $permintaan->created_at,
                    'pendonor_merespons' => $pendonorMerespons,
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error showDetail:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
    }

    /**
     * ✅ APPROVE PENDONOR - darah_didapat +1
     */
    public function approveResponden($responsId)
    {
        try {
            DB::beginTransaction();
            
            $respons = DB::table('respon_pendonor')->where('id', $responsId)->first();
            
            if (!$respons) {
                return response()->json(['success' => false, 'message' => 'Respons tidak ditemukan'], 404);
            }
            
            // Update status respons jadi approved
            DB::table('respon_pendonor')
                ->where('id', $responsId)
                ->update(['status' => 'approved', 'updated_at' => now()]);
            
            $permintaan = PermintaanDonor::findOrFail($respons->permintaan_id);
            
            // ✅ INCREMENT darah_didapat (+1)
            $darahDidapat = $permintaan->darah_didapat + 1;
            $permintaan->darah_didapat = $darahDidapat;
            
            // ✅ AUTO UPDATE STATUS jika darah_didapat >= jumlah_kantong
            if ($darahDidapat >= $permintaan->jumlah_kantong) {
                $permintaan->status_permintaan = 'Completed';
            }
            
            $permintaan->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pendonor berhasil diapprove',
                'darah_didapat' => $darahDidapat,
                'status' => $permintaan->status_permintaan
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * ✅ REJECT PENDONOR - Hapus data & responden -1
     */
    public function rejectResponden($responsId)
    {
        try {
            DB::beginTransaction();
            
            $respons = DB::table('respon_pendonor')->where('id', $responsId)->first();
            
            if (!$respons) {
                return response()->json(['success' => false, 'message' => 'Respons tidak ditemukan'], 404);
            }
            
            // ✅ HAPUS DATA RESPONS
            DB::table('respon_pendonor')->where('id', $responsId)->delete();
            
            $permintaan = PermintaanDonor::findOrFail($respons->permintaan_id);
            
            // ✅ DECREMENT responden (-1)
            if ($permintaan->responden > 0) {
                $permintaan->decrement('responden');
            }
            
            // ✅ AUTO UPDATE STATUS jadi Requesting
            if ($permintaan->status_permintaan === 'Responded') {
                $permintaan->update(['status_permintaan' => 'Requesting']);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pendonor berhasil ditolak dan dihapus',
                'responden_count' => $permintaan->responden,
                'status' => $permintaan->status_permintaan
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}