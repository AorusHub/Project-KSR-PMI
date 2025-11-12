<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Http\Controllers\DashboardController.php

namespace App\Http\Controllers;

use App\Models\KegiatanDonor;
use App\Models\PermintaanDonor;
use App\Models\DonasiDarah;
use App\Models\Pendonor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            'kegiatanTerbaru',
            'permintaanPending'
        ));
    }

    // Dashboard Staf
    public function stafDashboard()
    {
        $kegiatanPlanned = KegiatanDonor::where('status_permintaan', 'Approved')
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();
        
        $permintaanPending = PermintaanDonor::where('status_permintaan', 'Pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        $totalPendonor = Pendonor::count();
        $totalKegiatan = KegiatanDonor::count();

        return view('dashboard.staf', compact(
            'kegiatanPlanned',
            'permintaanPending',
            'totalPendonor',
            'totalKegiatan'
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
            ->where('status_donasi', 'Selesai')
            ->count();
        
        // Donasi terakhir
        $donasiTerakhir = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->where('status_donasi', 'Selesai')
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
    public function riwayatDonor()
    {
        $user = Auth::user();
        $pendonor = Pendonor::where('user_id', $user->user_id)->first();
        
        if (!$pendonor) {
            return redirect()->route('pendonor.dashboard')
                ->with('error', 'Data pendonor tidak ditemukan.');
        }
        
        // Ambil semua riwayat donasi dengan relasi kegiatan
        $riwayatDonasi = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->with('kegiatan')
            ->orderBy('tanggal_donasi', 'desc')
            ->paginate(10);
        
        // Statistik
        $totalBerhasil = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->where('status_donasi', 'Selesai')
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
            ->where('status_donasi', 'Selesai')
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

    // Export PDF Riwayat Donor
    public function exportPDF()
    {
        $user = Auth::user();
        $pendonor = Pendonor::where('user_id', $user->user_id)->first();
        
        if (!$pendonor) {
            return redirect()->route('pendonor.dashboard')
                ->with('error', 'Data pendonor tidak ditemukan.');
        }
        
        $riwayatDonasi = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->with('kegiatan')
            ->orderBy('tanggal_donasi', 'desc')
            ->get();
        
        $totalBerhasil = DonasiDarah::where('pendonor_id', $pendonor->pendonor_id)
            ->where('status_donasi', 'Selesai')
            ->count();
        
        $nyawaTerselamatkan = $totalBerhasil * 3;
        
        // TODO: Implement PDF export using barryvdh/laravel-dompdf
        // Install: composer require barryvdh/laravel-dompdf
        
        // Untuk sementara, return JSON
        return response()->json([
            'message' => 'Export PDF feature will be available soon',
            'pendonor' => $pendonor->nama,
            'total_donasi' => $totalBerhasil,
            'nyawa_terselamatkan' => $nyawaTerselamatkan,
        ]);
        
        // Setelah install DomPDF, uncomment code berikut:
        /*
        $pdf = \PDF::loadView('dashboard.pendonor.riwayat-pdf', compact(
            'pendonor',
            'riwayatDonasi',
            'totalBerhasil',
            'nyawaTerselamatkan'
        ));
        
        return $pdf->download('riwayat-donor-' . $pendonor->nama . '.pdf');
        */
    }
}