<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProfilMahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nim',
        'nama_lengkap',
        'fakultas',
        'prodi',
        'semester',
        'ipk',
        'penghasilan_ortu',
        'jumlah_tanggungan',
        'skor_prestasi',
        'alamat',
        'no_hp',
    ];

    protected function casts(): array
    {
        return [
            'ipk' => 'float',
            'penghasilan_ortu' => 'float',
            'jumlah_tanggungan' => 'integer',
            'skor_prestasi' => 'float',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pengajuan(): HasMany
    {
        return $this->hasMany(PengajuanBeasiswa::class, 'profil_id');
    }
}
