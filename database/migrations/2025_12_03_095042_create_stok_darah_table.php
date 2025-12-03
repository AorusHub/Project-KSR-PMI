<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\migrations\2024_12_03_000001_create_stok_darah_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_darah', function (Blueprint $table) {
            $table->id('stok_id');
            $table->enum('golongan_darah', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
            $table->integer('jumlah_kantong');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_darah');
    }
};