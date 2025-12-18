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
        'responden',          // ✅ TAMBAHAN BARU
        'darah_didapat', 
        'riwayat',
        'tempat_rawat',
        'jenis_permintaan',
        'tingkat_urgensi',
        'nama_kontak',
        'no_hp',
        'hubungan',
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
        'responden' => 'integer',        // ✅ CAST KE INTEGER
        'darah_didapat' => 'integer', 
    ];

    /**
     * Relasi ke DonasiDarah
     */
    public function donasiDarah()
    {
        return $this->hasMany(DonasiDarah::class, 'permintaan_id', 'permintaan_id');
    }

    public function tambahResponden()
    {
        $this->increment('responden');
        
        // ✅ AUTO UPDATE STATUS jika responden = jumlah_kantong
        if ($this->responden >= $this->jumlah_kantong) {
            $this->update(['status_permintaan' => 'Responded']);
        }
    }

    // ✅ METHOD: Kurangi responden + auto update status
    public function kurangiResponden()
    {
        if ($this->responden > 0) {
            $this->decrement('responden');
            
            // ✅ AUTO UPDATE STATUS jadi Requesting jika responden < jumlah_kantong
            if ($this->responden < $this->jumlah_kantong && $this->status_permintaan === 'Responded') {
                $this->update(['status_permintaan' => 'Requesting']);
            }
        }
    }

    public function responPendonor()
    {
        return $this->hasMany(ResponPendonor::class, 'permintaan_id', 'permintaan_id')
                    ->where('status', 'pending');
    }
    
    // ✅ TAMBAHKAN RELASI KE SEMUA RESPON (termasuk approved/rejected)
    public function semuaRespon()
    {
        return $this->hasMany(ResponPendonor::class, 'permintaan_id', 'permintaan_id');
    }
}