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
        'punya_transit',
        'transit_maskapai_id',
        'transit_wilayah_id',
        'transit_durasi_menit',
    ];

    protected $casts = [
        'punya_transit' => 'boolean',
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

    public function transit()
    {
        return $this->belongsTo(Wilayah::class, 'transit_wilayah_id');
    }

    public function transitMaskapai()
    {
        return $this->belongsTo(Maskapai::class, 'transit_maskapai_id');
    }

    // Maskapai yang dipakai setelah transit (fallback ke maskapai pertama)
    public function getMaskapaiLanjutanAttribute()
    {
        return $this->transitMaskapai ?? $this->maskapai;
    }

    // Contoh: "2 jam 30 menit"
    public function getTransitDurasiLabelAttribute(): ?string
    {
        if (! $this->punya_transit || ! $this->transit_durasi_menit) {
            return null;
        }

        $jam   = intdiv($this->transit_durasi_menit, 60);
        $menit = $this->transit_durasi_menit % 60;

        return trim(($jam ? "{$jam} jam " : '') . ($menit ? "{$menit} menit" : ''));
    }
}
