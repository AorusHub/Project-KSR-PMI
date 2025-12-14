<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('notifikasi', function (Blueprint $table) {
    $table->id('notifikasi_id');
    $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
    $table->string('judul_notif')->nullable();
    $table->string('jenis_notifikasi')->nullable();
    $table->text('pesan_notif')->nullable();  // ✅ Ganti dari isi_notifikasi ke pesan_notif
    $table->boolean('status_baca')->default(false);
    $table->timestamp('tanggal_notifikasi')->useCurrent();
    $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};