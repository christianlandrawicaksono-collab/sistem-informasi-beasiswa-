<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_saws', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_beasiswas')->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('kriteria_penilaians')->onDelete('cascade');
            $table->decimal('nilai_asli', 14, 2); // Raw value: e.g. IPK 3.85, Gaji 3500000
            $table->decimal('nilai_normalisasi', 8, 4)->nullable(); // Rij
            $table->decimal('nilai_terbobot', 8, 4)->nullable(); // Wj * Rij
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_saws');
    }
};
