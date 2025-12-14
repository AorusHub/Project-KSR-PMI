<?php

namespace App\Events;

use App\Models\PermintaanDonor;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PermintaanDonorCreated
{
    use Dispatchable, SerializesModels;

    public $permintaan;

    public function __construct(PermintaanDonor $permintaan)
    {
        $this->permintaan = $permintaan;
    }
}