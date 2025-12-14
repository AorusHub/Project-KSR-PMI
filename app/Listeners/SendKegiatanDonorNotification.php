<?php

namespace App\Listeners;

use App\Events\KegiatanDonorCreated;
use App\Models\Notifikasi;
use App\Models\User;

class SendKegiatanDonorNotification
{
    public function handle(KegiatanDonorCreated $event)
    {
        $pendonors = User::where('role', 'pendonor')
            ->whereHas('pendonor')
            ->get();

        foreach ($pendonors as $pendonor) {
            Notifikasi::create([
               'user_id' => $pendonor->user_id,
    'judul_notif' => 'Kegiatan Donor Baru',
    'jenis_notifikasi' => 'Kegiatan Baru',
    'pesan_notif' => "Kegiatan donor baru: {$event->kegiatan->nama_kegiatan} di {$event->kegiatan->lokasi} pada " . \Carbon\Carbon::parse($event->kegiatan->tanggal)->format('d M Y'),  // ✅ Ganti ke pesan_notif
    'status_baca' => false,
    'tanggal_notifikasi' => now(),
            ]);
        }
    }
}