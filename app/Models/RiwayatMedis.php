<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\RiwayatMedis.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatMedis extends Model
{
    use HasFactory;

    protected $table = 'riwayat_medis';
    protected $primaryKey = 'id_riwayat_medis';

    protected $fillable = [
        'id_pendonor',
        'berat_badan',
        'tekanan_darah',
        'hb',
        'hasil_kelayakan',
        'keterangan',
    ];

    protected $casts = [
        'berat_badan' => 'decimal:2',
        'hb' => 'decimal:2',
    ];

    // Relationships
    public function pendonor()
    {
        return $this->belongsTo(Pendonor::class, 'id_pendonor', 'id_pendonor');
    }
}