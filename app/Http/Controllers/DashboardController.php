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

class DashboardController extends Controller
{
    // Dashboard Admin
    public function adminDashboard()
    {
        $totalPendonor = Pendonor::count();
        $totalKegiatan = KegiatanDonor::count();
        $totalPermintaan = PermintaanDonor::count();
        $totalDonasi = DonasiDarah::count();
        
        $kegiatanTerbaru = KegiatanDonor::latest()->take(5)->get();
        $permintaanPending = PermintaanDonor::where('status_permintaan', 'Pending')->get();

        return view('dashboard.admin', compact(
            'totalPendonor',
            'totalKegiatan',
            'totalPermintaan',
            'totalDonasi',
            'kegiatanTerbaru',
            'permintaanPending'
        ));
    }

    // Dashboard Staf
    public function stafDashboard()
    {
        $kegiatanPlanned = KegiatanDonor::where('status', 'Planned')->get();
        $permintaanPending = PermintaanDonor::where('status_permintaan', 'Pending')->get();
        $totalPendonor = Pendonor::count();

        return view('dashboard.staf', compact(
            'kegiatanPlanned',
            'permintaanPending',
            'totalPendonor'
        ));
    }

    // Dashboard Pendonor
    public function pendonorDashboard()
    {
        $user = Auth::user();
        $pendonor = $user->pendonor;
        
        $kegiatanTersedia = KegiatanDonor::where('status', 'Planned')
            ->where('tanggal', '>=', now())
            ->get();
        
        $riwayatDonasi = DonasiDarah::where('id_pendonor', $pendonor->id_pendonor)
            ->latest()
            ->take(5)
            ->get();
        
        $pendaftaranSaya = $pendonor->pendaftaranKegiatan()
            ->with('kegiatan')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.pendonor', compact(
            'pendonor',
            'kegiatanTersedia',
            'riwayatDonasi',
            'pendaftaranSaya'
        ));
    }
}