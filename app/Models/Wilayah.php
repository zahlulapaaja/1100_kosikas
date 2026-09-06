<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $fillable = [
        'airport_name',
        'code_iata',
        'code_icao',
        'city_name',
        'province_name',
        'country',
        'latitude',
        'longitude',
        'timezone',
        'type',
        'is_active',
    ];

    protected $casts = [
        'latitude'  => 'decimal:7',
        'longitude' => 'decimal:7',
        'is_active' => 'boolean',
    ];

    public function label(): string
    {
        return "{$this->city_name} ({$this->code_iata})";
    }
}
