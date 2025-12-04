<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\StokDarah.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokDarah extends Model
{
    use HasFactory;

    protected $table = 'stok_darah';
    protected $primaryKey = 'stok_id';

    protected $fillable = [
        'golongan_darah',
        'jenis_darah',
        'jumlah_kantong',
        'keterangan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}