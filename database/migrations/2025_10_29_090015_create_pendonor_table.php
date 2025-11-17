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
            
            // Data Pribadi
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('no_hp', 15);
            $table->string('NIK', 16)->unique()->nullable();
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('golongan_darah', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
            $table->text('alamat')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendonor');
    }
};