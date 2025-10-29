<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\KegiatanDonor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanDonor extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_donor';
    protected $primaryKey = 'id_kegiatan';

    protected $fillable = [
        'nama_kegiatan',
        'tanggal',
        'lokasi',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relationships
    public function pendaftaran()
    {
        return $this->hasMany(PendaftaranKegiatan::class, 'id_kegiatan', 'id_kegiatan');
    }

    public function partisipan()
    {
        return $this->hasMany(PartisipanKegiatan::class, 'id_kegiatan', 'id_kegiatan');
    }

    public function donasiDarah()
    {
        return $this->hasMany(DonasiDarah::class, 'id_kegiatan', 'id_kegiatan');
    }
}