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
    public $timestamps = true;

    protected $fillable = [
        'nomor_pelacakan',
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
        // ✅ DATA PENDONOR YANG MERESPONS
        'nama_pendonor_respond',
        'tgl_lahir_pendonor',
        'gol_darah_pendonor',
        'no_telp_pendonor',
        'tanggal_respond'
    ];

    protected $casts = [
        'tanggal_hari' => 'date',
        'tgl_lahir_pendonor' => 'date',
        'tanggal_respond' => 'datetime',
    ];

    /**
     * Relasi ke DonasiDarah
     */
    public function donasiDarah()
    {
        return $this->hasMany(DonasiDarah::class, 'permintaan_id', 'permintaan_id');
    }
}