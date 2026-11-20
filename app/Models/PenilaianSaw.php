<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenilaianSaw extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengajuan_id',
        'kriteria_id',
        'nilai_asli',
        'nilai_normalisasi',
        'nilai_terbobot',
    ];

    protected function casts(): array
    {
        return [
            'nilai_asli' => 'float',
            'nilai_normalisasi' => 'float',
            'nilai_terbobot' => 'float',
        ];
    }

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(PengajuanBeasiswa::class, 'pengajuan_id');
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(KriteriaPenilaian::class, 'kriteria_id');
    }
}
