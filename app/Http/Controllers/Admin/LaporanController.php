<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Http\Controllers\Admin\LaporanController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonasiDarah;
use App\Models\Pendonor;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        // Total Kantong Darah Terkumpul (status_donasi bukan status_donor)
        $totalKantong = DonasiDarah::where('status_donasi', 'Berhasil')->count();
        
        // Kantong Bulan Ini
        $kantongBulanIni = DonasiDarah::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->where('status_donasi', 'Berhasil')
            ->count();
        
        // Tren Kantong Darah Terkumpul (6 Bulan Terakhir)
        $trenKantong = [];
        $bulanNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        for ($i = 5; $i >= 0; $i--) {
            $bulan = date('m', strtotime("-$i months"));
            $tahun = date('Y', strtotime("-$i months"));
            
            $jumlah = DonasiDarah::whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->where('status_donasi', 'Berhasil')
                ->count();
            
            $trenKantong[] = [
                'bulan' => $bulanNames[(int)$bulan - 1],
                'jumlah' => $jumlah
            ];
        }
        
        // Total Donasi untuk Distribusi Golongan Darah
        // Ambil dari tabel pendonor yang punya donasi berhasil
        $totalDonasi = DonasiDarah::where('status_donasi', 'Berhasil')
            ->whereHas('pendonor')
            ->count();
        
        // Distribusi Golongan Darah (ambil dari tabel pendonor via join)
        $distribusiGoldar = DonasiDarah::join('pendonor', 'donasi_darah.pendonor_id', '=', 'pendonor.pendonor_id')
            ->select('pendonor.golongan_darah', DB::raw('count(*) as total'))
            ->where('donasi_darah.status_donasi', 'Berhasil')
            ->whereNotNull('pendonor.golongan_darah')
            ->groupBy('pendonor.golongan_darah')
            ->get()
            ->map(function($item) use ($totalDonasi) {
                $persentase = $totalDonasi > 0 ? round(($item->total / $totalDonasi) * 100) : 0;
                return [
                    'golongan' => $item->golongan_darah,
                    'total' => $item->total,
                    'persentase' => $persentase
                ];
            });
        
        return view('dashboard.admin.laporan', compact(
            'totalKantong',
            'kantongBulanIni',
            'trenKantong',
            'totalDonasi',
            'distribusiGoldar'
        ));
    }
}