<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->string('kategori'); // Prestasi Akademik, Bantuan Ekonomi, Eksternal
            $table->string('penyelenggara'); // Internal UNIKA, Djarum, BI, dll
            $table->integer('kuota')->default(0);
            $table->date('tgl_buka');
            $table->date('tgl_tutup');
            $table->text('deskripsi')->nullable();
            $table->text('persyaratan')->nullable();
            $table->decimal('ipk_minimal', 3, 2)->default(3.00);
            $table->enum('status', ['buka', 'tutup', 'selesai'])->default('buka');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beasiswas');
    }
};
