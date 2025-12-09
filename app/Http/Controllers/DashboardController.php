<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Http\Controllers\DashboardController.php

namespace App\Http\Controllers;

use App\Models\KegiatanDonor;
use App\Models\PermintaanDonor;
use App\Models\DonasiDarah;
use App\Models\Pendonor;
use App\Models\VerifikasiKelayakan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    // Dashboard Admin
public function adminDashboard()
    {
        // Total Pendonor
        $totalPendonor = Pendonor::count();
        $pendonorBulanIni = Pendonor::whereMonth('created_at', now()->month)->count();
        
        // Kantong Terkumpul (Total Volume Darah)
        $totalVolumeMl = DonasiDarah::where('status_donasi', 'Berhasil')
            ->sum('volume_darah');
        $kantongTerkumpul = round($totalVolumeMl / 350);
        $kantongBulanIni = DonasiDarah::where('status_donasi', 'Berhasil')
            ->whereMonth('tanggal_donasi', now()->month)
            ->sum('volume_darah');
        
        // Kegiatan Aktif
        $kegiatanAktif = KegiatanDonor::whereIn('status', ['Completed', 'Planned'])->count();
        $totalKegiatan = KegiatanDonor::count();
        
        // Permintaan Baru (Pending)
        $permintaanBaru = PermintaanDonor::where('status_permintaan', 'Pending')->count();
        
        // Tingkat Keberhasilan
        $totalDonasi = DonasiDarah::count();
        $donasiSelesai = DonasiDarah::where('status_donasi', 'Berhasil')->count();
        $tingkatKeberhasilan = $totalDonasi > 0 ? round(($donasiSelesai / $totalDonasi) * 100) : 0;
        
        // Pendonor Aktif (yang sudah donor di 6 bulan terakhir)
        $pendonorAktif = DonasiDarah::where('status_donasi', 'Berhasil')
            ->where('tanggal_donasi', '>=', now()->subMonths(6))
            ->distinct('pendonor_id')
            ->count('pendonor_id');
        
        // Permintaan Terpenuhi
        $permintaanTerpenuhi = PermintaanDonor::where('status_permintaan', 'Approved')->count();

         // ✅ Stok Darah (sama dengan kantong terkumpul)
        $stokDarah = $kantongTerkumpul;
        
        // Data untuk tabel
        $kegiatanTerbaru = KegiatanDonor::orderBy('tanggal', 'desc')->take(5)->get();
        $permintaanPending = PermintaanDonor::where('status_permintaan', 'Pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalPendonor',
            'pendonorBulanIni',
            'kantongTerkumpul',
            'kantongBulanIni',
            'kegiatanAktif',
            'totalKegiatan',
            'permintaanBaru',
            'tingkatKeberhasilan',
            'pendonorAktif',
            'permintaanTerpenuhi',
            'stokDarah',
            'kegiatanTerbaru',
            'permintaanPending'
        ));
    }

    // Dashboard Staf
    public function stafDashboard()
    {
        // Stats untuk dashboard staf
        $permintaanBaru = PermintaanDonor::where('status_permintaan', 'Pending')->count();
        $kegiatanAktif = KegiatanDonor::whereIn('status', ['Planned', 'Ongoing'])->count();
        $partisipanBulanIni = DonasiDarah::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $totalKegiatan = KegiatanDonor::count();
        
        // ✅ VERIFIKASI KELAYAKAN - DATA REAL
        $menungguVerifikasi = VerifikasiKelayakan::where('status_kelayakan', 'Menunggu')->count();
        $historyVerifikasi = VerifikasiKelayakan::whereIn('status_kelayakan', ['Layak', 'Tidak Layak'])->count();
        
        // ✅ AMBIL PERMINTAAN DONOR TERBARU DARI DATABASE
        $permintaanTerbaru = PermintaanDonor::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Kegiatan yang Sedang Berjalan
        $kegiatanBerjalan = KegiatanDonor::whereIn('status', ['Planned', 'Ongoing'])
            ->orderBy('tanggal', 'asc')
            ->take(4)
            ->get();

        return view('dashboard.staf', compact(
            'permintaanBaru',
            'kegiatanAktif',
            'partisipanBulanIni',
            'totalKegiatan',
            'menungguVerifikasi',
            'historyVerifikasi',
            'permintaanTerbaru',
            'kegiatanBerjalan'
        ));
    }

    // Dashboard Pendonor
    public function pendonorDashboard()
    {
        $user = Auth::user();
        
        // Cek apakah user punya data pendonor
        $pendonor = Pendonor::where('user_id', $user->user_id)->first();
        
        // Kegiatan tersedia (yang akan datang)
        $kegiatanTersedia = KegiatanDonor::where('status', 'Planned')
            ->where('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->take(3)
            ->get();
        
        // Riwayat donasi (ambil 5 terakhir untuk dashboard)
        // BARIS 84: Ganti 'tanggal_donasi' jadi 'tanggal_donasi'
        $riwayatDonasi = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->orderBy('tanggal_donasi', 'desc')
            ->take(5)
            ->get();
        
        // Hitung total donasi yang selesai
        $totalDonasi = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->where('status_donasi', 'Berhasil')
            ->count();
        
        // Donasi terakhir
        $donasiTerakhir = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->where('status_donasi', 'Berhasil')
            ->orderBy('tanggal_donasi', 'desc')
            ->first();
        
        // Hitung tanggal donor berikutnya (3 bulan dari donasi terakhir)
        $donorBerikutnya = null;
        $bisaDonor = true;
        
        if ($donasiTerakhir) {
            $donorBerikutnya = Carbon::parse($donasiTerakhir->tanggal_donasi)->addMonths(3);
            $bisaDonor = now()->greaterThanOrEqualTo($donorBerikutnya);
        }

        return view('dashboard.pendonor', compact(
            'pendonor',
            'kegiatanTersedia',
            'riwayatDonasi',
            'totalDonasi',
            'donasiTerakhir',
            'donorBerikutnya',
            'bisaDonor'
        ));
    }
    

    // Halaman Riwayat Donor (Detail)
    public function riwayatDonor($id = null)
    {
        $user = Auth::user();
        
        // ✅ Jika admin mengakses dengan ID pendonor tertentu
        if ($user->role === 'admin' && $id) {
            $pendonor = Pendonor::findOrFail($id);
        } 
        // ✅ Jika pendonor login, ambil data sendiri (tidak pakai ID)
        elseif ($user->role === 'pendonor') {
            $pendonor = Pendonor::where('user_id', $user->user_id)->first();
            
            if (!$pendonor) {
                return redirect()->route('pendonor.dashboard')
                    ->with('error', 'Data pendonor tidak ditemukan.');
            }
        } 
        // ✅ Role lain tidak boleh akses
        else {
            abort(403, 'Unauthorized access.');
        }
        
        // Ambil semua riwayat donasi dengan relasi kegiatan
        $riwayatDonasi = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->with('kegiatan')
            ->orderBy('tanggal_donasi', 'desc')
            ->paginate(10);
        
        // Statistik
        $totalBerhasil = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->where('status_donasi', 'Berhasil')
            ->count();
        
        $totalPending = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->where('status_donasi', 'Pending')
            ->count();
        
        $totalDibatalkan = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->where('status_donasi', 'Dibatalkan')
            ->count();
        
        $nyawaTerselamatkan = $totalBerhasil * 3; // 1 kantong darah = 3 nyawa
        
        // Hitung persentase keberhasilan
        $totalDonasi = $riwayatDonasi->total();
        $persentaseKeberhasilan = $totalDonasi > 0 ? round(($totalBerhasil / $totalDonasi) * 100) : 0;
        
        // Total volume darah yang didonasikan (ml)
        $totalVolume = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->where('status_donasi', 'Berhasil')
            ->sum('volume_darah');
        
        return view('dashboard.pendonor.riwayat-donor', compact(
            'pendonor',
            'riwayatDonasi',
            'totalBerhasil',
            'totalPending',
            'totalDibatalkan',
            'nyawaTerselamatkan',
            'persentaseKeberhasilan',
            'totalVolume'
        ));
    }

    // ✅ Export PDF Riwayat Donor - SUPPORT ADMIN & PENDONOR
    public function exportPDF($id = null)
    {
        $user = Auth::user();
        
        // ✅ Jika admin mengakses dengan ID pendonor tertentu
        if ($user->role === 'admin' && $id) {
            $pendonor = Pendonor::findOrFail($id);
        } 
        // ✅ Jika pendonor login, ambil data sendiri
        elseif ($user->role === 'pendonor') {
            $pendonor = Pendonor::where('user_id', $user->user_id)->first();
            
            if (!$pendonor) {
                return redirect()->route('pendonor.dashboard')
                    ->with('error', 'Data pendonor tidak ditemukan.');
            }
        } 
        // ✅ Role lain tidak boleh akses
        else {
            abort(403, 'Unauthorized access.');
        }
        
        $riwayatDonasi = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->with('kegiatan')
            ->orderBy('tanggal_donasi', 'desc')
            ->get();
        
        $totalBerhasil = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->where('status_donasi', 'Berhasil')
            ->count();
        
        $nyawaTerselamatkan = $totalBerhasil * 3;
        
        // ✅ Total volume darah
        $totalVolume = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->where('status_donasi', 'Berhasil')
            ->sum('volume_darah');
        
        // ✅ Hitung persentase keberhasilan
        $totalDonasi = $riwayatDonasi->count();
        $persentaseKeberhasilan = $totalDonasi > 0 ? round(($totalBerhasil / $totalDonasi) * 100) : 0;
        
        // ✅ Generate PDF
        $pdf = \PDF::loadView('dashboard.pendonor.riwayat-donor-pdf', compact(
            'pendonor',
            'riwayatDonasi',
            'totalBerhasil',
            'nyawaTerselamatkan',
            'totalVolume',
            'persentaseKeberhasilan'
        ));
        
        $filename = 'riwayat-donor-' . \Str::slug($pendonor->nama) . '-' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    public function profil()
    {
        $user = Auth::user();
        $pendonor = Pendonor::where('user_id', $user->user_id)->first();
        
        if (!$pendonor) {
            return redirect()->route('pendonor.dashboard')
                ->withErrors(['error' => 'Data pendonor tidak ditemukan.']);
        }

        // Hitung statistik donasi
        $totalDonasi = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->where('status_donasi', 'Berhasil')
            ->count();
        
        // Total kantong darah yang didonasikan
        $totalKantong = $totalDonasi; // 1 donasi = 1 kantong
        
        // Donor terakhir
        $donorTerakhirData = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->where('status_donasi', 'Berhasil')
            ->orderBy('tanggal_donasi', 'desc')
            ->first();
        
        $donorTerakhir = $donorTerakhirData 
            ? Carbon::parse($donorTerakhirData->tanggal_donasi)->format('d/m/Y') 
            : null;
        
         // Donor berikutnya (3 bulan dari donor terakhir)
        $donorBerikutnya = $donorTerakhirData 
            ? Carbon::parse($donorTerakhirData->tanggal_donasi)->addMonths(3)->format('d/m/Y') 
            : null;
        
        return view('dashboard.pendonor.pendonor-profile', compact(
            'pendonor', 
            'totalDonasi', 
            'totalKantong', 
            'donorTerakhir', 
            'donorBerikutnya'
        ));
    }

    /**
     * Update profil pendonor
     */
    public function updateProfil(Request $request)
    {
        $validated = $request->validate([
            'tanggal_lahir' => 'required|date|before:today',
            'password' => 'nullable|min:8',
        ], [
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        $user = Auth::user();
        $pendonor = Pendonor::where('user_id', $user->user_id)->first();
        
        if (!$pendonor) {
            return redirect()->route('pendonor.dashboard')
                ->withErrors(['error' => 'Data pendonor tidak ditemukan.']);
        }

        // Update data pendonor
        $pendonor->update([
            'tanggal_lahir' => $validated['tanggal_lahir'],
        ]);

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->update([
                'password' => bcrypt($validated['password'])
            ]);
        }

        return redirect()->route('pendonor.profil')
            ->with('success', 'Profil berhasil diperbarui!');
    }

}