<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berkas_syarats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_beasiswas')->onDelete('cascade');
            $table->string('nama_dokumen'); // KTM, KTP, Transkrip KHS, KK, Slip Gaji, Sertifikat
            $table->string('file_path');
            $table->string('file_type')->nullable(); // pdf, jpg, png
            $table->integer('file_size')->nullable(); // in KB
            $table->boolean('wajib')->default(true);
            $table->enum('status_verifikasi', ['pending', 'valid', 'perlu_revisi', 'ditolak'])->default('pending');
            $table->text('catatan_verifikasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas_syarats');
    }
};
