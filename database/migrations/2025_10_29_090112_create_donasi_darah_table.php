<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\migrations\2025_10_29_090112_create_donasi_darah_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donasi_darah', function (Blueprint $table) {
            $table->id('donasi_id');
            $table->foreignId('pendonor_id')->constrained('pendonor', 'pendonor_id')->onDelete('cascade');
            $table->date('tanggal_donasi');
            $table->enum('jenis_donor', ['Sukarela', 'Pengganti']);
            $table->foreignId('kegiatan_id')->nullable()->constrained('kegiatan_donor', 'kegiatan_id')->onDelete('set null');
            $table->foreignId('permintaan_id')->nullable()->constrained('permintaan_donor', 'permintaan_id')->onDelete('set null');
            $table->string('lokasi_donor');
            $table->integer('volume_darah')->default(350); // ✅ TAMBAHKAN INI (dalam ml)
            $table->enum('status_donasi', ['Berhasil', 'Gagal'])->default('Berhasil');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donasi_darah');
    }
};