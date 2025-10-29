<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donasi_darah', function (Blueprint $table) {
            $table->id('id_donasi');
            $table->foreignId('id_pendonor')->constrained('pendonor', 'id_pendonor')->onDelete('cascade');
            $table->date('tgl_donasi');
            $table->enum('jenis_donor', ['Sukarela', 'Pengganti']);
            $table->foreignId('id_kegiatan')->nullable()->constrained('kegiatan_donor', 'id_kegiatan')->onDelete('set null');
            $table->foreignId('id_permintaan')->nullable()->constrained('permintaan_donor', 'id_permintaan')->onDelete('set null');
            $table->string('lokasi_donor');
            $table->enum('status_donasi', ['Berhasil', 'Gagal']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donasi_darah');
    }
};