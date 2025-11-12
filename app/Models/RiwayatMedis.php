<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\RiwayatMedis.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatMedis extends Model
{
    use HasFactory;

    protected $table = 'riwayat_medis';
    protected $primaryKey = 'riwayat_medis_id';

    protected $fillable = [
        'pendonor_id',
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
        return $this->belongsTo(Pendonor::class, 'pendonor_id', 'pendonor_id');
    }
}