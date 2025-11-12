<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Models\InfoUtd.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoUtd extends Model
{
    use HasFactory;

    protected $table = 'info_utd';
    protected $primaryKey = 'utd_id';

    protected $fillable = [
        'nama_utd',
        'alamat',
        'no_telp',
        'jam_buka',
    ];
}