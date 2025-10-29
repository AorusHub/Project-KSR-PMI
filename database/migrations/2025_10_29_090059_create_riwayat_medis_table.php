<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_medis', function (Blueprint $table) {
            $table->id('id_riwayat_medis');
            $table->foreignId('id_pendonor')->constrained('pendonor', 'id_pendonor')->onDelete('cascade');
            $table->decimal('berat_badan', 5, 2);
            $table->string('tekanan_darah');
            $table->decimal('hb', 4, 2);
            $table->enum('hasil_kelayakan', ['Layak', 'Tidak Layak']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_medis');
    }
};