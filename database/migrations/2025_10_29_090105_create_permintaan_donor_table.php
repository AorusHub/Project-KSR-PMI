<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permintaan_donor', function (Blueprint $table) {
            $table->id('id_permintaan');
            $table->date('tanggal_hari');
            $table->string('nama_pasien');
            $table->enum('gol_darah', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
            $table->integer('jumlah_kantong');
            $table->string('kontak_keluarga');
            $table->enum('status_permintaan', ['Pending', 'Approved', 'Completed', 'Rejected'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_donor');
    }
};