<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\PermintaanDonor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanDonor extends Model
{
    use HasFactory;

    protected $table = 'permintaan_donor';
    protected $primaryKey = 'permintaan_id';

    protected $fillable = [
        'nomor_pelacakan', // ✅ Tambahkan ini
        'tanggal_hari',
        'nama_pasien',
        'gol_darah',
        'jumlah_kantong',
        'riwayat',
        'tempat_rawat',
        'jenis_permintaan',
        'tingkat_urgensi',
        'nama_kontak',
        'no_hp',
        'hubungan',
        'kontak_keluarga',
        'status_permintaan',
    ];

    protected $casts = [
        'tanggal_hari' => 'date',
    ];

    // Relationships
    public function donasiDarah()
    {
        return $this->hasMany(DonasiDarah::class, 'permintaan_id', 'permintaan_id');
    }
}