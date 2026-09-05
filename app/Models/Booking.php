<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_name',
        'agency_tagline',
        'pnr',
        'issued_date',
        'currency',
        'total_fare',
        'fare_note',
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

    public function getLionAirTrackingUrlAttribute(): ?string
    {
        $flight = $this->flights->first();
        $passenger = $this->passengers->first();

        if (!$flight || !$passenger || !$flight->maskapai) {
            return null;
        }

        if ($flight->maskapai->group !== 'Lion Air Group') {
            return null;
        }

        $nameParts = explode(' ', trim($passenger->name), 2);
        $firstName = $nameParts[0];
        $surname   = $nameParts[1] ?? $nameParts[0];

        return 'https://secure2.lionair.co.id/lionairpnr2/RetrieveBooking.aspx?' . http_build_query([
            'BookingReloc' => $this->pnr,
            'FirstName'    => $firstName,
            'Surname'      => $surname,
            'FlightNumber' => $flight->flight_no,
            'FlightDate'   => \Carbon\Carbon::parse($flight->departure_date)->format('dMY'), // 02Sep2026
        ]);
    }
}
