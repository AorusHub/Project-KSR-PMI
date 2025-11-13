<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendonor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    public function index()
    {
        $pengguna = Pendonor::with(['user', 'donasiDarah'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalPengguna = $pengguna->count();

        return view('dashboard.admin.user-management', compact('pengguna', 'totalPengguna'));
    }

    public function riwayatDonasi($id)
    {
        $pendonor = Pendonor::with(['donasiDarah.kegiatan'])
            ->findOrFail($id);
        
        $totalDonasi = $pendonor->donasiDarah->count();
        $totalBerhasil = $pendonor->donasiDarah->where('status_donasi', 'Selesai')->count();
        $totalGagal = $pendonor->donasiDarah->where('status_donasi', '!=', 'Selesai')->count();
        
        return view('dashboard.admin.detail-user-management', compact(
            'pendonor',
            'totalDonasi',
            'totalBerhasil',
            'totalGagal'
        ));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $pendonor = Pendonor::findOrFail($id);
            $nama = $pendonor->nama;
            
            $pendonor->donasiDarah()->delete();
            
            if ($pendonor->user_id) {
                User::where('user_id', $pendonor->user_id)->delete();
            }
            
            $pendonor->delete();
            
            DB::commit();
            
            return redirect()->route('admin.users.index')
                ->with('success', "Data pengguna {$nama} berhasil dihapus");
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.users.index')
                ->with('error', 'Gagal menghapus data pengguna: ' . $e->getMessage());
        }
    }
}