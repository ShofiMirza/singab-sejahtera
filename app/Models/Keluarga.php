<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    protected $table = 'keluarga';
    public $incrementing = false;  // Disable auto-incrementing
    protected $keyType = 'string'; // Set ID type to string
    
    protected $fillable = [
        'id',
        'nama_kk',
        'alamat',
        'rt',
        'rw',
        'latitude',
        'longitude',
        'kategori',
        'kondisi_rumah',
        'status_bantuan'
    ];

    public function fotoRumah()
    {
        return $this->hasOne(FotoRumah::class);
    }

    public function detailBantuan()
    {
        return $this->hasMany(DetailBantuan::class);
    }
} 