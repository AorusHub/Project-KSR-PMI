<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partisipan_kegiatan', function (Blueprint $table) {
            $table->id('partisipan_id');
            $table->foreignId('kegiatan_id')->constrained('kegiatan_donor', 'kegiatan_id')->onDelete('cascade');
            $table->foreignId('pendonor_id')->constrained('pendonor', 'pendonor_id')->onDelete('cascade');
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