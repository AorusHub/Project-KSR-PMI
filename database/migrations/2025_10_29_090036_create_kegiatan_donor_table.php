<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan_donor', function (Blueprint $table) {
            $table->id('kegiatan_id');
            $table->string('nama_kegiatan', 100);
            $table->date('tanggal');
            $table->time('waktu_mulai')->default('09:00');
            $table->time('waktu_selesai')->default('15:00');
            $table->string('lokasi');
            $table->string('rincian_lokasi', 255);
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->text('deskripsi')->nullable();
            $table->integer('target_donor')->nullable();
            $table->enum('status', ['Completed', 'Planned', 'Ongoing', 'Cancelled'])->default('Planned');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan_donor');
    }
};