<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    protected $fillable = [
        'kode_kecamatan',
        'nama_kecamatan',
    ];

    public function desas(): HasMany
    {
        return $this->hasMany(Desa::class);
    }
}
