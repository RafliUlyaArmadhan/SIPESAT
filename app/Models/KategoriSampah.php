<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriSampah extends Model
{
    protected $table = 'kategori_sampah';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];
}