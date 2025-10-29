<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_kegiatan', function (Blueprint $table) {
            $table->id('id_pendaftaran');
            $table->foreignId('id_pendonor')->constrained('pendonor', 'id_pendonor')->onDelete('cascade');
            $table->foreignId('id_kegiatan')->constrained('kegiatan_donor', 'id_kegiatan')->onDelete('cascade');
            $table->date('tgl_daftar');
            $table->enum('status_pendaftaran', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->date('tgl_acc')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_kegiatan');
    }
};