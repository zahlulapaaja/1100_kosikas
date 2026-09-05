<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerbangan extends Model
{
    protected $fillable = [
        'wilayah_asal_id',
        'wilayah_tujuan_id',
        'maskapai_id',
        'jam_berangkat',
        'jam_sampai',
    ];

    public function asal()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_asal_id');
    }

    public function tujuan()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_tujuan_id');
    }

    public function maskapai()
    {
        return $this->belongsTo(Maskapai::class, 'maskapai_id');
    }
}
