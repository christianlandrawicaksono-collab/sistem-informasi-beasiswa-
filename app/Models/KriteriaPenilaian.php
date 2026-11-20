<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KriteriaPenilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'beasiswa_id',
        'kode_kriteria',
        'nama_kriteria',
        'bobot',
        'sifat',
    ];

    protected function casts(): array
    {
        return [
            'bobot' => 'float',
        ];
    }

    public function beasiswa(): BelongsTo
    {
        return $this->belongsTo(Beasiswa::class, 'beasiswa_id');
    }

    public function penilaianSaws(): HasMany
    {
        return $this->hasMany(PenilaianSaw::class, 'kriteria_id');
    }
}
