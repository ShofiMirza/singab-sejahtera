<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoRumah extends Model
{
    protected $table = 'foto_rumah';
    
    protected $fillable = [
        'keluarga_id',
        'foto_depan',
        'foto_samping',
        'foto_dalam'
    ];

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class);
    }
} 