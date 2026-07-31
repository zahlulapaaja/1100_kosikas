<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id', 'maskapai_id', 'origin_wilayah_id', 'destination_wilayah_id',
        'flight_no', 'departure_date', 'dep_time', 'arr_time', 'subclass',
    ];

    protected $casts = [
        'departure_date' => 'date',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function maskapai()
    {
        return $this->belongsTo(Maskapai::class);
    }

    public function origin()
    {
        return $this->belongsTo(Wilayah::class, 'origin_wilayah_id');
    }

    public function destination()
    {
        return $this->belongsTo(Wilayah::class, 'destination_wilayah_id');
    }
}
