<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendonor', function (Blueprint $table) {
            $table->id('pendonor_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->string('NIK', 16)->unique();
            $table->text('alamat');
            $table->date('tgl_lahir');
            $table->enum('golongan_darah', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendonor');
    }
};