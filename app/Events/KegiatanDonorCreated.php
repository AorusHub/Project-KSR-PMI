<?php

namespace App\Events;

use App\Models\KegiatanDonor;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KegiatanDonorCreated
{
    use Dispatchable, SerializesModels;

    public $kegiatan;

    public function __construct(KegiatanDonor $kegiatan)
    {
        $this->kegiatan = $kegiatan;
    }
}