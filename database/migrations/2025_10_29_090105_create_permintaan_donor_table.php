<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\migrations\2025_10_29_090105_create_permintaan_donor_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permintaan_donor', function (Blueprint $table) {
            $table->id('permintaan_id');
            
            // ✅ Nomor pelacakan
            $table->string('nomor_pelacakan', 20)->unique();
            
            $table->date('tanggal_hari');
            $table->string('nama_pasien');
            $table->enum('gol_darah', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
            $table->integer('jumlah_kantong');

            $table->integer('responden')->default(0)->comment('Jumlah pendonor yang merespons');
            $table->integer('darah_didapat')->default(0)->comment('Jumlah kantong darah yang berhasil didapat');
            
            // Field permintaan
            $table->text('riwayat')->nullable();
            $table->string('tempat_rawat');
            $table->enum('jenis_permintaan', [
                'Darah Lengkap (Whole Blood)',
                'Packed Red Cells (PRC)',
                'Trombosit (TC)',
                'Plasma'
            ])->default('Darah Lengkap (Whole Blood)');
            $table->enum('tingkat_urgensi', ['Sangat Mendesak', 'Mendesak', 'Normal'])->default('Normal');
            
            // Kontak penanggung jawab
            $table->string('nama_kontak');
            $table->string('no_hp');
            $table->string('hubungan');
            
            // Field lama (backwards compatibility)
            $table->enum('status_permintaan', [
                'Pending', 
                'Approved',
                'Failed',
                'Completed', 
                'Rejected', 
                'Requesting',
                'Responded'
            ])->default('Pending');
    
            // ✅ DATA PENDONOR YANG MERESPONS
            $table->string('nama_pendonor_respond')->nullable();
            $table->date('tgl_lahir_pendonor')->nullable();
            $table->string('gol_darah_pendonor', 10)->nullable();
            $table->string('no_telp_pendonor', 15)->nullable();
            $table->timestamp('tanggal_respond')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_donor');
    }
};