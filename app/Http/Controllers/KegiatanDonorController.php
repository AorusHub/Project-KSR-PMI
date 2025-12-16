<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Http\Controllers\KegiatanDonorController.php

namespace App\Http\Controllers;

use App\Models\KegiatanDonor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DonasiDarah;
use App\Events\KegiatanDonorCreated;
use App\Http\Controllers\NotifikasiController;


class KegiatanDonorController extends Controller
{
    public function index()
    {
        // ✅ Update status kegiatan otomatis sebelum tampilkan
        $this->updateKegiatanStatus();
        
        // ✅ Hitung batas waktu: 1 hari yang lalu dari sekarang
        $oneDayAgo = now()->subDay();
        
        // ✅ Ambil kegiatan "Planned", "Ongoing", dan "Completed" (max 1 hari setelah selesai)
        $kegiatan = KegiatanDonor::with('donasiDarah')
            ->where(function($query) use ($oneDayAgo) {
                $query->whereIn('status', ['Planned', 'Ongoing'])
                    ->orWhere(function($q) use ($oneDayAgo) {
                        // Completed yang tanggalnya dalam 1 hari terakhir
                        $q->where('status', 'Completed')
                            ->where('tanggal', '>=', $oneDayAgo->toDateString());
                    });
            })
            ->orderByRaw("CASE 
                WHEN status = 'Ongoing' THEN 1 
                WHEN status = 'Planned' THEN 2 
                WHEN status = 'Completed' THEN 3 
                ELSE 4 END") // Ongoing → Planned → Completed
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->paginate(12);
        
        return view('kegiatan.daftar_kegiatan', compact('kegiatan'));
    }

    private function updateKegiatanStatus()
    {
        $now = now();
        
        // 1. ✅ Update "Planned" → "Ongoing" (kegiatan yang sudah dimulai)
        $kegiatanDimulai = KegiatanDonor::where('status', 'Planned')
            ->where(function($query) use ($now) {
                $query->whereDate('tanggal', '<', $now->toDateString())
                    ->orWhere(function($q) use ($now) {
                        $q->whereDate('tanggal', '=', $now->toDateString())
                            ->whereTime('waktu_mulai', '<=', $now->toTimeString());
                    });
            })
            ->get();
        
        foreach ($kegiatanDimulai as $kegiatan) {
            $kegiatan->update(['status' => 'Ongoing']);
            
            // ✅ Kirim notifikasi "Kegiatan Dimulai"
            NotifikasiController::sendActivityStarted($kegiatan);
        }
        
        // 2. ✅ Update "Ongoing" → "Completed" (kegiatan yang sudah selesai)
        $kegiatanSelesai = KegiatanDonor::where('status', 'Ongoing')
            ->where(function($query) use ($now) {
                $query->whereDate('tanggal', '<', $now->toDateString())
                    ->orWhere(function($q) use ($now) {
                        $q->whereDate('tanggal', '=', $now->toDateString())
                            ->whereTime('waktu_selesai', '<=', $now->toTimeString());
                    });
            })
            ->get();
        
        foreach ($kegiatanSelesai as $kegiatan) {
            $kegiatan->update(['status' => 'Completed']);
            
            // ✅ Kirim notifikasi "Kegiatan Selesai"
            NotifikasiController::sendActivityFinished($kegiatan);
        }
    }

    // Public: Detail kegiatan
    public function show($id)
    {
        $kegiatan = KegiatanDonor::with(['donasiDarah' => function($query) {
                $query->whereHas('pendonor.user');
            }, 'donasiDarah.pendonor.user'])
            ->findOrFail($id);
        
        // ✅ BLOKIR akses pendonor jika kegiatan Completed > 1 hari
        if (Auth::check() && Auth::user()->role === 'pendonor') {
            $oneDayAgo = now()->subDay();
            
            if ($kegiatan->status === 'Completed' && $kegiatan->tanggal < $oneDayAgo->toDateString()) {
                abort(404, 'Kegiatan tidak tersedia');
            }
        }
        
        $totalDonor = $kegiatan->donasiDarah->count();
        
        return view('kegiatan.detail_kegiatan', compact('kegiatan', 'totalDonor'));
    }

    // ✅ PERBAIKI METHOD DAFTAR
    public function daftar(Request $request, $id)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login terlebih dahulu'
                ], 401);
            }

            $user = Auth::user();
            
            if (!$user->pendonor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum melengkapi data pendonor.'
                ], 403);
            }

            $kegiatan = KegiatanDonor::findOrFail($id);

            // ✅ BLOKIR pendaftaran jika kegiatan Completed > 1 hari
            $oneDayAgo = now()->subDay();
            if ($kegiatan->status === 'Completed' && $kegiatan->tanggal < $oneDayAgo->toDateString()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kegiatan ini sudah tidak tersedia untuk pendaftaran'
                ], 403);
            }

            // ✅ BLOKIR pendaftaran jika kegiatan sudah Completed
            if ($kegiatan->status === 'Completed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Kegiatan ini sudah selesai, tidak bisa mendaftar lagi'
                ], 403);
            }

            // Cek apakah sudah pernah daftar
            $sudahDaftar = DonasiDarah::where('pendonor_id', $user->pendonor->pendonor_id)
                ->where('kegiatan_id', $kegiatan->kegiatan_id)
                ->exists();

            if ($sudahDaftar) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah terdaftar untuk kegiatan ini'
                ], 400);
            }

            // ✅ TAMBAHKAN lokasi_donor
            DonasiDarah::create([
                'pendonor_id' => $user->pendonor->pendonor_id,
                'kegiatan_id' => $kegiatan->kegiatan_id,
                'tanggal_donasi' => $kegiatan->tanggal,
                'jenis_donor' => 'Sukarela',
                'lokasi_donor' => $kegiatan->lokasi,
                'status_donasi' => 'Terdaftar',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendaftar kegiatan donor darah'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error daftar kegiatan:', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    // Admin: Daftar semua kegiatan (Manajemen Kegiatan)
    public function adminIndex()
    {
        // Cek role user
        if (!in_array(Auth::user()->role, ['admin', 'staf'])) {
            abort(403, 'Unauthorized action.');
        }

        $kegiatan = KegiatanDonor::with('donasiDarah')
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function($item) {
                // Hitung partisipan
                $item->partisipan = $item->donasiDarah->count();
                
                // Format tanggal
                $item->tanggal_formatted = \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y');
                
                // Tentukan status badge
                $now = now();
                $tanggalKegiatan = \Carbon\Carbon::parse($item->tanggal);
                
                if ($item->status === 'Ongoing') {
                    $item->status_label = 'Berlangsung';
                    $item->status_color = 'green';
                } elseif ($item->status === 'Completed') {
                    $item->status_label = 'Selesai';
                    $item->status_color = 'gray';
                } elseif ($item->status === 'Cancelled') {
                    $item->status_label = 'Dibatalkan';
                    $item->status_color = 'red';
                } elseif ($tanggalKegiatan->isFuture()) {
                    $item->status_label = 'Akan Datang';
                    $item->status_color = 'blue';
                } else {
                    $item->status_label = 'Berlangsung';
                    $item->status_color = 'green';
                }
                
                return $item;
            });
        
        return view('dashboard.dev.managemen_kegiatan', compact('kegiatan'));
    }

    // Admin: Form create
    public function create()
    {
        return view('admin.kegiatan.create');
    } 

    // Admin: Store kegiatan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'lokasi' => 'required|string|max:200',
            'rincian_lokasi' => 'nullable|string|max:255', // ✅ TAMBAH INI
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'deskripsi' => 'nullable|string',
            'target_donor' => 'nullable|integer|min:0',
            'status' => 'required|in:Planned,Ongoing,Completed,Cancelled',
        ]);

        $validated['created_by'] = Auth::id();

        if (empty($validated['waktu_selesai'])) {
            $validated['waktu_selesai'] = '14:00';
        }

        // ✅ TAMBAHKAN INI - YANG HILANG!
        if (empty($validated['rincian_lokasi'])) {
            $validated['rincian_lokasi'] = '-';
        }
        
        $kegiatan = KegiatanDonor::create($validated);
        event(new KegiatanDonorCreated($kegiatan));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kegiatan donor berhasil ditambahkan!'
            ]);
        }

        return redirect()->route('managemen.kegiatan.index')
            ->with('success', 'Kegiatan donor berhasil ditambahkan!');
    }

    // Admin: Form edit
    public function edit($id)
    {
        $kegiatan = KegiatanDonor::findOrFail($id);
        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    // Admin: Update kegiatan
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'nama_kegiatan' => 'required|string|max:100',
                'tanggal' => 'required|date',
                'waktu_mulai' => 'required',
                'waktu_selesai' => 'nullable',
                'lokasi' => 'required|string|max:200',
                'rincian_lokasi' => 'nullable|string|max:255', // ✅ TAMBAH INI
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'deskripsi' => 'nullable|string',
                'target_donor' => 'nullable|integer|min:0',
                'status' => 'required|in:Planned,Ongoing,Completed,Cancelled',
            ]);
             // ✅ Set default values
            if (empty($validated['rincian_lokasi'])) {
                $validated['rincian_lokasi'] = '-';
            }

            $kegiatan = KegiatanDonor::findOrFail($id);

            $oldStatus = $kegiatan->status;

            $kegiatan->update($validated);
            
            

            // ✅ KIRIM NOTIFIKASI saat status berubah
            if ($oldStatus !== 'Ongoing' && $validated['status'] === 'Ongoing') {
                // Kegiatan baru dimulai
                NotifikasiController::sendActivityStarted($kegiatan);
            }
            
            if ($oldStatus !== 'Completed' && $validated['status'] === 'Completed') {
                // Kegiatan selesai
                NotifikasiController::sendActivityFinished($kegiatan);
            }

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Kegiatan donor berhasil diupdate!'
                ]);
            }

            return redirect()->route('managemen.kegiatan.index')
                ->with('success', 'Kegiatan donor berhasil diupdate!');
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Admin: Delete kegiatan
    public function destroy($id)
    {
        $kegiatan = KegiatanDonor::findOrFail($id);
        $kegiatan->delete();

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan donor berhasil dihapus!');
    }

    // Staf: Update status kegiatan
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Planned,Ongoing,Completed,Cancelled',
        ]);

        $kegiatan = KegiatanDonor::findOrFail($id);
        $oldStatus = $kegiatan->status;
        $kegiatan->update(['status' => $validated['status']]);

        // ✅ KIRIM NOTIFIKASI saat status berubah
        if ($oldStatus !== 'Ongoing' && $validated['status'] === 'Ongoing') {
                NotifikasiController::sendActivityStarted($kegiatan);
        }
            
        if ($oldStatus !== 'Completed' && $validated['status'] === 'Completed') {
                NotifikasiController::sendActivityFinished($kegiatan);
        }

        return redirect()->back()
            ->with('success', 'Status kegiatan berhasil diupdate!');
    }

    public function peserta($id)
    {
        // Cek role
        if (!in_array(Auth::user()->role, ['admin', 'staf'])) {
            abort(403, 'Unauthorized action.');
        }

        $kegiatan = KegiatanDonor::findOrFail($id);
        
        // ✅ LOAD partisipan dengan whereHas untuk filter yang punya pendonor & user
        $partisipans = DonasiDarah::where('kegiatan_id', $id)
            ->whereHas('pendonor.user') // ✅ FILTER hanya yang punya pendonor & user
            ->with('pendonor.user')
            ->paginate(10);

        return view('dashboard.dev.partisipan-kegiatan', compact('kegiatan', 'partisipans'));
    }

    // ✅ PERBAIKI METHOD SEARCH PESERTA
    public function searchPeserta(Request $request, $id)
    {
        // Cek role
        if (!in_array(Auth::user()->role, ['admin', 'staf'])) {
            abort(403, 'Unauthorized action.');
        }

        $kegiatan = KegiatanDonor::findOrFail($id);
        $search = $request->input('search');

        // Search partisipan
        $partisipans = DonasiDarah::where('kegiatan_id', $id)
            ->whereHas('pendonor.user') // ✅ FILTER hanya yang punya pendonor & user
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