<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BerkasSyarat extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengajuan_id',
        'nama_dokumen',
        'file_path',
        'file_type',
        'file_size',
        'wajib',
        'status_verifikasi',
        'catatan_verifikasi',
    ];

    protected function casts(): array
    {
        return [
            'wajib' => 'boolean',
            'file_size' => 'integer',
        ];
    }

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(PengajuanBeasiswa::class, 'pengajuan_id');
    }
}
