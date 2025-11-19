<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['pendonor', 'staf', 'admin'])->default('pendonor');
            $table->string('otp_code')->nullable(); //yang ditambahkan
            $table->dateTime('otp_expires_at')->nullable(); //yang ditambahkan
            $table->boolean('is_verified')->default(false); //yang ditambahka
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};