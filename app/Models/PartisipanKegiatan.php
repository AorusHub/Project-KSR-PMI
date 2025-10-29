<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\PartisipanKegiatan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartisipanKegiatan extends Model
{
    use HasFactory;

    protected $table = 'partisipan_kegiatan';
    protected $primaryKey = 'id_partisipan';

    protected $fillable = [
        'id_kegiatan',
        'id_pendonor',
        'status_donasi',
        'alasan_gagal',
    ];

    // Relationships
    public function kegiatan()
    {
        return $this->belongsTo(KegiatanDonor::class, 'id_kegiatan', 'id_kegiatan');
    }

    public function pendonor()
    {
        return $this->belongsTo(Pendonor::class, 'id_pendonor', 'id_pendonor');
    }
}