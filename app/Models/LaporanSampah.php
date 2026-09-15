<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanSampah extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_laporan',
        'user_id',
        'kategori_sampah_id',
        'kecamatan',
        'desa',
        'judul_laporan',
        'deskripsi',
        'alamat_lengkap',
        'latitude',
        'longitude',
        'foto_laporan',
        'status',
        'alasan_penolakan',
        'verified_by',
        'verified_at',
        'completed_at',
    ];

    protected $casts = [
        'foto_laporan' => 'array',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'verified_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Laporan dibuat oleh masyarakat.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Laporan memiliki kategori sampah.
     */
    public function kategoriSampah(): BelongsTo
    {
        return $this->belongsTo(KategoriSampah::class);
    }

    /**
     * User yang melakukan verifikasi laporan.
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}