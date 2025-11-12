<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_kegiatan', function (Blueprint $table) {
            $table->id('pendaftaran_id');
            $table->foreignId('pendonor_id')->constrained('pendonor', 'pendonor_id')->onDelete('cascade');
            $table->foreignId('kegiatan_id')->constrained('kegiatan_donor', 'kegiatan_id')->onDelete('cascade');
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