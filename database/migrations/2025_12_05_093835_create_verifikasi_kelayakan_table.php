<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\database\migrations\2025_12_05_000001_create_verifikasi_kelayakan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifikasi_kelayakan', function (Blueprint $table) {
            $table->id('verifikasi_id');
            $table->foreignId('pendonor_id')->constrained('pendonor', 'pendonor_id')->onDelete('cascade');
            
             // Data Pasien (sesuai urutan di gambar)
            $table->enum('golongan_darah', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
            $table->decimal('berat_badan', 5, 2); // kg
            
            // Pertanyaan Kesehatan (urutan sesuai gambar)
            $table->boolean('sedang_sakit_demam_batuk_pilek_flu')->default(false);
            $table->boolean('konsumsi_obat')->default(false);
            $table->boolean('riwayat_penyakit_hepatitis_hiv_sifilis')->default(false);
            $table->boolean('pernah_ditato_ditindik_diupanat_6bulan')->default(false);
            $table->boolean('sedang_hamil_menyusui_melahirkan_6bulan')->default(false);
            $table->boolean('menerima_operasi_transfusi_1tahun')->default(false);
            $table->boolean('ke_daerah_endemis_malaria_1tahun')->default(false);
            $table->boolean('alergi_obat_makanan_transfusi')->default(false);
            
            $table->text('keterangan_tambahan')->nullable();
            
            // Hasil Verifikasi
            $table->enum('status_kelayakan', ['Menunggu', 'Layak', 'Tidak Layak'])->default('Menunggu');
            $table->text('catatan_petugas')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users', 'user_id')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasi_kelayakan');
    }
};