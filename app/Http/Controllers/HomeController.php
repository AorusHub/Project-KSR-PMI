<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Http\Controllers\HomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KegiatanDonor;
use App\Models\Pendonor;
use App\Models\DonasiDarah;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data untuk homepage
        $totalPendonor = Pendonor::count();
        $totalDonasi = DonasiDarah::where('status_donasi', 'Selesai')->count();
        $totalKegiatan = KegiatanDonor::whereYear('tanggal', date('Y'))->count();
        
        // Kegiatan terdekat
        $kegiatanTerdekat = KegiatanDonor::where('status', 'Planned')
            ->where('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->take(3)
            ->get();
        
        return view('home', compact(
            'totalPendonor',
            'totalDonasi',
            'totalKegiatan',
            'kegiatanTerdekat'
        ));
    }
}