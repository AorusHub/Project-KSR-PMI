<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\PermintaanDonor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanDonor extends Model
{
    use HasFactory;

    protected $table = 'permintaan_donor';
    protected $primaryKey = 'id_permintaan';

    protected $fillable = [
        'tanggal_hari',
        'nama_pasien',
        'gol_darah',
        'jumlah_kantong',
        'kontak_keluarga',
        'status_permintaan',
    ];

    protected $casts = [
        'tanggal_hari' => 'date',
    ];

    // Relationships
    public function donasiDarah()
    {
        return $this->hasMany(DonasiDarah::class, 'id_permintaan', 'id_permintaan');
    }
}