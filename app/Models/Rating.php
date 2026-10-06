<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_sampah_id',
        'user_id',
        'rating',
        'komentar',
    ];

    public function laporanSampah()
    {
        return $this->belongsTo(
            LaporanSampah::class,
            'laporan_sampah_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}