<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\KegiatanDonorCreated;
use App\Listeners\SendKegiatanDonorNotification;
use App\Events\PermintaanDonorCreated;
use App\Listeners\SendPermintaanDonorNotification;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Daftarkan event listener untuk notifikasi kegiatan baru
        Event::listen(
            KegiatanDonorCreated::class,
            SendKegiatanDonorNotification::class
        );

        // ✅ Event untuk permintaan donor mendesak
        Event::listen(
            PermintaanDonorCreated::class,
            SendPermintaanDonorNotification::class
        );
    }
}