<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_beasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_id')->constrained('profil_mahasiswas')->onDelete('cascade');
            $table->foreignId('beasiswa_id')->constrained('beasiswas')->onDelete('cascade');
            $table->string('nomor_pendaftaran')->unique();
            $table->enum('status_tahap', [
                'draft',
                'submitted',
                'verifikasi_berkas',
                'seleksi_saw',
                'diterima',
                'ditolak'
            ])->default('draft');
            $table->decimal('total_skor_saw', 8, 4)->nullable();
            $table->integer('peringkat')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->dateTime('tgl_pengajuan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_beasiswas');
    }
};
