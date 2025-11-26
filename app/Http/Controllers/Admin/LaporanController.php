<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Http\Controllers\Admin\LaporanController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonasiDarah;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        // Total Kantong Darah Terkumpul
        $totalKantong = DonasiDarah::where('status_donasi', 'Berhasil')->count();
        
        // Kantong Bulan Ini
        $kantongBulanIni = DonasiDarah::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->where('status_donasi', 'Berhasil')
            ->count();
        
        // Tren Kantong Darah Terkumpul (24 Bulan Terakhir untuk mendukung filter 2 tahun)
        $trenKantong = [];
        $bulanNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        for ($i = 23; $i >= 0; $i--) {
            $bulan = date('m', strtotime("-$i months"));
            $tahun = date('Y', strtotime("-$i months"));
            
            $jumlah = DonasiDarah::whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->where('status_donasi', 'Berhasil')
                ->count();
            
            $trenKantong[] = [
                'bulan' => $bulanNames[(int)$bulan - 1] . ' ' . substr($tahun, 2),
                'jumlah' => $jumlah
            ];
        }
        
        // Total Donasi untuk Distribusi Golongan Darah (default 6 bulan)
        $totalDonasi = DonasiDarah::where('status_donasi', 'Berhasil')
            ->whereHas('pendonor')
            ->count();
        
        // Distribusi Golongan Darah (default 6 bulan)
        $distribusiGoldar = DonasiDarah::join('pendonor', 'donasi_darah.pendonor_id', '=', 'pendonor.pendonor_id')
            ->select('pendonor.golongan_darah', DB::raw('count(*) as total'))
            ->where('donasi_darah.status_donasi', 'Berhasil')
            ->whereNotNull('pendonor.golongan_darah')
            ->groupBy('pendonor.golongan_darah')
            ->orderByRaw("FIELD(pendonor.golongan_darah, 'O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-')")
            ->get()
            ->map(function($item) use ($totalDonasi) {
                $persentase = $totalDonasi > 0 ? round(($item->total / $totalDonasi) * 100) : 0;
                return [
                    'golongan' => $item->golongan_darah,
                    'total' => $item->total,
                    'persentase' => $persentase
                ];
            });
        
        // Data untuk semua periode (1, 3, 6, 12, 24 bulan)
        $distribusiGoldarPeriode = [];
        $periods = [1, 3, 6, 12, 24];
        
        foreach ($periods as $months) {
            $startDate = now()->subMonths($months);
            
            // Total donasi untuk periode ini
            $totalPeriode = DonasiDarah::where('status_donasi', 'Berhasil')
                ->where('created_at', '>=', $startDate)
                ->whereHas('pendonor')
                ->count();
            
            // Distribusi golongan darah untuk periode ini
            $distribusiPeriode = DonasiDarah::join('pendonor', 'donasi_darah.pendonor_id', '=', 'pendonor.pendonor_id')
                ->select('pendonor.golongan_darah', DB::raw('count(*) as total'))
                ->where('donasi_darah.status_donasi', 'Berhasil')
                ->where('donasi_darah.created_at', '>=', $startDate)
                ->whereNotNull('pendonor.golongan_darah')
                ->groupBy('pendonor.golongan_darah')
                ->orderByRaw("FIELD(pendonor.golongan_darah, 'O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-')")
                ->get()
                ->map(function($item) use ($totalPeriode) {
                    $persentase = $totalPeriode > 0 ? round(($item->total / $totalPeriode) * 100) : 0;
                    return [
                        'golongan' => $item->golongan_darah,
                        'total' => $item->total,
                        'persentase' => $persentase
                    ];
                })
                ->toArray();
            
            $distribusiGoldarPeriode[$months] = [
                'total' => $totalPeriode,
                'distribusi' => $distribusiPeriode
            ];
        }
        
        return view('dashboard.admin.laporan', compact(
            'totalKantong',
            'kantongBulanIni',
            'trenKantong',
            'totalDonasi',
            'distribusiGoldar',
            'distribusiGoldarPeriode'
        ));
    }
}