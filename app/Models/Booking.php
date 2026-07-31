<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_name', 'agency_tagline', 'pnr', 'issued_date',
        'currency', 'total_fare', 'fare_note',
    ];

    protected $casts = [
        'issued_date' => 'date',
        'total_fare'  => 'decimal:2',
    ];

    public function flights()
    {
        return $this->hasMany(Flight::class)->orderBy('departure_date');
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class);
    }
}
