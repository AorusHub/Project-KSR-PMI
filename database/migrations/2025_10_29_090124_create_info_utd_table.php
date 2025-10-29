<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('info_utd', function (Blueprint $table) {
            $table->id('id_utd');
            $table->string('nama_utd');
            $table->text('alamat');
            $table->string('no_telp');
            $table->string('jam_buka');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('info_utd');
    }
};