<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kriteria_penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beasiswa_id')->constrained('beasiswas')->onDelete('cascade');
            $table->string('kode_kriteria'); // C1, C2, C3, C4
            $table->string('nama_kriteria'); // IPK, Penghasilan, Tanggungan, Prestasi
            $table->decimal('bobot', 5, 2); // e.g. 40.00, 30.00, 20.00, 10.00
            $table->enum('sifat', ['benefit', 'cost']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kriteria_penilaians');
    }
};
