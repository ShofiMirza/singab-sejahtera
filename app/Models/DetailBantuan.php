<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBantuan extends Model
{
    protected $table = 'detail_bantuan';
    
    protected $fillable = [
        'keluarga_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'catatan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date'
    ];

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class);
    }
} 