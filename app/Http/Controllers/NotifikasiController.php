<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function getLatest()
    {
        if (!Auth::check()) {
            return response()->json([], 401);
        }

        $notifications = Notifikasi::where('user_id', Auth::id())
            ->orderBy('tanggal_notifikasi', 'desc')
            ->take(5)
            ->get()
            ->map(function($notif) {
                return [
                    'id' => $notif->notifikasi_id,
                    'jenis' => $notif->jenis_notifikasi,
                    'isi' => $notif->pesan_notif,
                    'dibaca' => (bool)$notif->status_baca,
                    'waktu' => $notif->tanggal_notifikasi->diffForHumans(),
                    'icon_type' => $this->getIconType($notif->jenis_notifikasi),
                    'url' => $this->getNotificationUrl($notif->jenis_notifikasi),  // ✅ Tambahkan URL
                ];
            });

        return response()->json($notifications);
    }

    public function getUnreadCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0], 401);
        }

        $count = Notifikasi::where('user_id', Auth::id())
            ->where('status_baca', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function markAsRead($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false], 401);
        }

        $notif = Notifikasi::where('notifikasi_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($notif) {
            $notif->update(['status_baca' => true]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function markAllAsRead()
    {
        if (!Auth::check()) {
            return response()->json(['success' => false], 401);
        }

        Notifikasi::where('user_id', Auth::id())
            ->where('status_baca', false)
            ->update(['status_baca' => true]);

        return response()->json(['success' => true]);
    }

    private function getNotificationUrl($jenis)
    {
        $user = Auth::user();
    
    return match($jenis) {
        'Kegiatan Baru' => in_array($user->role, ['admin', 'staf']) 
            ? route('managemen.kegiatan.index')
            : route('kegiatan.index'),
        'Permintaan Darurat' => $user->role === 'pendonor'
            ? route('pendonor.permintaan-darah')  // ✅ UBAH DARI permintaan-donor.index
            : route('managemen.permintaan-darurat.index'),
        'Donasi Berhasil' => route('pendonor.riwayat-donor'),
        'Pengingat' => route('pendonor.dashboard'),
        default => route('home'),
    };
}
    private function getIconType($jenis)
    {
        return match($jenis) {
            'Kegiatan Baru' => 'blue',
            'Donasi Berhasil' => 'green',
            'Pengingat' => 'yellow',
            'Permintaan Darurat' => 'red',
            default => 'gray',
        };
    }
}