<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\VerifikasiKelayakan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VerifikasiKelayakan extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_kelayakan';
    protected $primaryKey = 'verifikasi_id';

    protected $fillable = [
        'pendonor_id',
        'golongan_darah',
        'berat_badan',
        'sedang_sakit_demam_batuk_pilek_flu',
        'konsumsi_obat',
        'riwayat_penyakit_hepatitis_hiv_sifilis',
        'pernah_ditato_ditindik_diupanat_6bulan',
        'sedang_hamil_menyusui_melahirkan_6bulan',
        'menerima_operasi_transfusi_1tahun',
        'ke_daerah_endemis_malaria_1tahun',
        'alergi_obat_makanan_transfusi',
        'keterangan_tambahan',
        'status_kelayakan',
        'catatan_petugas',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'berat_badan' => 'decimal:2',
        'sedang_sakit_demam_batuk_pilek_flu' => 'boolean',
        'konsumsi_obat' => 'boolean',
        'riwayat_penyakit_hepatitis_hiv_sifilis' => 'boolean',
        'pernah_ditato_ditindik_diupanat_6bulan' => 'boolean',
        'sedang_hamil_menyusui_melahirkan_6bulan' => 'boolean',
        'menerima_operasi_transfusi_1tahun' => 'boolean',
        'ke_daerah_endemis_malaria_1tahun' => 'boolean',
        'alergi_obat_makanan_transfusi' => 'boolean',
        'verified_at' => 'datetime',
    ];

    // Relasi ke Pendonor
    public function pendonor()
    {
        return $this->belongsTo(Pendonor::class, 'pendonor_id', 'pendonor_id');
    }

    // Relasi ke User (Petugas yang verifikasi)
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by', 'user_id');
    }

    // Helper method untuk cek apakah layak donor
    public function isLayak()
    {
        return $this->status_kelayakan === 'Layak';
    }

    // Helper method untuk cek apakah menunggu verifikasi
    public function isMenunggu()
    {
        return $this->status_kelayakan === 'Menunggu';
    }

    // Scope untuk filter status
    public function scopeMenunggu($query)
    {
        return $query->where('status_kelayakan', 'Menunggu');
    }

    public function scopeLayak($query)
    {
        return $query->where('status_kelayakan', 'Layak');
    }

    public function scopeTidakLayak($query)
    {
        return $query->where('status_kelayakan', 'Tidak Layak');
    }
}