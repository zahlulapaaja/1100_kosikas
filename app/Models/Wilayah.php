<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $fillable = ['city_name', 'airport_code', 'country'];

    public function label(): string
    {
        return "{$this->city_name} ({$this->airport_code})";
    }
}
