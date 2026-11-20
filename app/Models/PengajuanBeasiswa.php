<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PengajuanBeasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'profil_id',
        'beasiswa_id',
        'nomor_pendaftaran',
        'status_tahap',
        'total_skor_saw',
        'peringkat',
        'catatan_admin',
        'tgl_pengajuan',
    ];

    protected function casts(): array
    {
        return [
            'total_skor_saw' => 'float',
            'peringkat' => 'integer',
            'tgl_pengajuan' => 'datetime',
        ];
    }

    public function profil(): BelongsTo
    {
        return $this->belongsTo(ProfilMahasiswa::class, 'profil_id');
    }

    public function beasiswa(): BelongsTo
    {
        return $this->belongsTo(Beasiswa::class, 'beasiswa_id');
    }

    public function berkas(): HasMany
    {
        return $this->hasMany(BerkasSyarat::class, 'pengajuan_id');
    }

    public function penilaianSaw(): HasMany
    {
        return $this->hasMany(PenilaianSaw::class, 'pengajuan_id');
    }
}
