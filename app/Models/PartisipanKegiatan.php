<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\PartisipanKegiatan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartisipanKegiatan extends Model
{
    use HasFactory;

    protected $table = 'partisipan_kegiatan';
    protected $primaryKey = 'partisipan_id';

    protected $fillable = [
        'kegiatan_id',
        'pendonor_id',
        'status_donasi',
        'alasan_gagal',
    ];

    // Relationships
    public function kegiatan()
    {
        return $this->belongsTo(KegiatanDonor::class, 'kegiatan_id', 'kegiatan_id');
    }

    public function pendonor()
    {
        return $this->belongsTo(Pendonor::class, 'pendonor_id', 'pendonor_id');
    }
}