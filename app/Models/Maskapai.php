<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maskapai extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code_iata', 'code_icao', 'logo'];

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }

    /**
     * URL publik logo maskapai, atau null kalau belum ada logo yang diupload.
     */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset($this->logo) : null;
    }
}
