<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partisipan_kegiatan', function (Blueprint $table) {
            $table->id('id_partisipan');
            $table->foreignId('id_kegiatan')->constrained('kegiatan_donor', 'id_kegiatan')->onDelete('cascade');
            $table->foreignId('id_pendonor')->constrained('pendonor', 'id_pendonor')->onDelete('cascade');
            $table->enum('status_donasi', ['Berhasil', 'Gagal']);
            $table->text('alasan_gagal')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partisipan_kegiatan');
    }
};