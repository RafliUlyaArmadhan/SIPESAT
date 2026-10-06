<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanSampah extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_laporan',
        'user_id',
        'kategori_sampah_id',
        'kecamatan_id',
        'desa_id',
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
        'completed_at'
    ];

    protected $casts = [
        'foto_laporan' => 'array',
        'verified_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI USER PELAPOR
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI KATEGORI SAMPAH
    |--------------------------------------------------------------------------
    */
    public function kategoriSampah()
    {
        return $this->belongsTo(KategoriSampah::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI KECAMATAN
    |--------------------------------------------------------------------------
    */
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DESA
    |--------------------------------------------------------------------------
    */
    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN YANG MEMVERIFIKASI
    |--------------------------------------------------------------------------
    */
    public function verifiedBy()
    {
        return $this->belongsTo(
            User::class,
            'verified_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PENUGASAN PETUGAS
    |--------------------------------------------------------------------------
    */
    public function penugasan()
    {
        return $this->hasOne(Penugasan::class);
    }

    /*
    |--------------------------------------------------------------------------
    | DOKUMENTASI PENANGANAN
    |--------------------------------------------------------------------------
    */
    public function dokumentasiPenanganan()
    {
        return $this->hasOne(
            DokumentasiPenanganan::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT STATUS
    |--------------------------------------------------------------------------
    */
    public function laporanStatusHistories()
    {
        return $this->hasMany(
            LaporanStatusHistory::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RATING DARI MASYARAKAT
    |--------------------------------------------------------------------------
    | 1 laporan hanya memiliki 1 rating
    |--------------------------------------------------------------------------
    */
    public function rating()
    {
        return $this->hasOne(Rating::class);
    }
}