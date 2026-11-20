<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_program',
        'kategori',
        'penyelenggara',
        'kuota',
        'tgl_buka',
        'tgl_tutup',
        'deskripsi',
        'persyaratan',
        'ipk_minimal',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tgl_buka' => 'date',
            'tgl_tutup' => 'date',
            'ipk_minimal' => 'float',
            'kuota' => 'integer',
        ];
    }

    public function kriteria(): HasMany
    {
        return $this->hasMany(KriteriaPenilaian::class, 'beasiswa_id');
    }

    public function pengajuan(): HasMany
    {
        return $this->hasMany(PengajuanBeasiswa::class, 'beasiswa_id');
    }
}
