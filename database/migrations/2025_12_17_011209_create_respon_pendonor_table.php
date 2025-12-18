<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('respon_pendonor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permintaan_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pendonor_id')->nullable();
            $table->string('nama_pendonor');
            $table->date('tgl_lahir');
            $table->string('gol_darah', 10);
            $table->string('no_telp', 15);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
            
            // ✅ INDEX saja, TANPA FOREIGN KEY
            $table->index('permintaan_id');
            $table->index('user_id');
            $table->index('pendonor_id');
            $table->unique(['permintaan_id', 'user_id'], 'unique_user_per_permintaan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('respon_pendonor');
    }
};