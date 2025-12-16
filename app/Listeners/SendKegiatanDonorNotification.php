<?php   

namespace App\Listeners;

use App\Events\KegiatanDonorCreated;
use App\Models\Notifikasi;
use App\Models\User;

class SendKegiatanDonorNotification
{
    public function handle(KegiatanDonorCreated $event)
    {
        // Dapatkan nama pembuat kegiatan
        $creator = User::find($event->kegiatan->created_by);
        $creatorName = $creator ? $creator->name : 'Admin';
        $creatorRole = $creator ? ucfirst($creator->role) : 'Admin';
        
        // 1. ✅ Kirim/Update ke PENDONOR
        $pendonors = User::where('role', 'pendonor')
            ->whereHas('pendonor')
            ->get();

        foreach ($pendonors as $pendonor) {
            // ✅ Cari notifikasi BELUM DIBACA yang sudah ada
            $existingNotif = Notifikasi::where('user_id', $pendonor->user_id)
                ->where('jenis_notifikasi', 'Kegiatan Baru')
                ->where('status_baca', false)
                ->first();
            
            if ($existingNotif) {
                // ✅ Hitung total kegiatan baru yang belum dibaca (SETELAH notif ini)
                $jumlahBelumDibaca = Notifikasi::where('user_id', $pendonor->user_id)
                    ->where('jenis_notifikasi', 'Kegiatan Baru')
                    ->where('status_baca', false)
                    ->count() + 1; // +1 untuk kegiatan baru ini
                
                // ✅ UPDATE notifikasi yang ada
                $existingNotif->update([
                    'pesan_notif' => "Terdapat {$jumlahBelumDibaca} kegiatan yang telah dibuat oleh {$creatorRole}.",
                    'tanggal_notifikasi' => now(),
                ]);
            } else {
                // ✅ BUAT notifikasi baru (ini kegiatan pertama yang belum dibaca)
                Notifikasi::create([
                    'user_id' => $pendonor->user_id,
                    'judul_notif' => 'Kegiatan Donor Baru',
                    'jenis_notifikasi' => 'Kegiatan Baru',
                    'pesan_notif' => "Kegiatan baru telah dibuat oleh {$creatorRole}.",
                    'status_baca' => false,
                    'tanggal_notifikasi' => now(),
                ]);
            }
        }

        // 2. ✅ Kirim/Update ke ADMIN/STAF (kecuali yang buat kegiatan)
        $creatorRoleCheck = $creator?->role;
        
        // Jika pembuat admin → kirim ke staf, jika pembuat staf → kirim ke admin
        $targetRole = ($creatorRoleCheck === 'admin') ? ['staf'] : ['admin'];
        
        $adminStaff = User::whereIn('role', $targetRole)
            ->where('user_id', '!=', $event->kegiatan->created_by)
            ->get();

        foreach ($adminStaff as $user) {
            // ✅ Cari notifikasi BELUM DIBACA yang sudah ada
            $existingNotif = Notifikasi::where('user_id', $user->user_id)
                ->where('jenis_notifikasi', 'Kegiatan Baru')
                ->where('status_baca', false)
                ->first();
            
            if ($existingNotif) {
                // ✅ Hitung total kegiatan baru yang belum dibaca (SETELAH notif ini)
                $jumlahBelumDibaca = Notifikasi::where('user_id', $user->user_id)
                    ->where('jenis_notifikasi', 'Kegiatan Baru')
                    ->where('status_baca', false)
                    ->count() + 1; // +1 untuk kegiatan baru ini
                
                // ✅ UPDATE notifikasi yang ada
                $existingNotif->update([
                    'pesan_notif' => "Terdapat {$jumlahBelumDibaca} kegiatan baru yang dibuat oleh {$creatorRole}.",
                    'tanggal_notifikasi' => now(),
                ]);
            } else {
                // ✅ BUAT notifikasi baru (ini kegiatan pertama yang belum dibaca)
                Notifikasi::create([
                    'user_id' => $user->user_id,
                    'judul_notif' => 'Kegiatan Donor Baru',
                    'jenis_notifikasi' => 'Kegiatan Baru',
                    'pesan_notif' => "Kegiatan baru telah dibuat oleh {$creatorRole}.",
                    'status_baca' => false,
                    'tanggal_notifikasi' => now(),
                ]);
            }
        }
    }
}