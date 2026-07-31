<?php

namespace Database\Seeders;

use App\Models\Maskapai;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $maskapais = [
            ['name' => 'Super Air Jet', 'code' => 'IU'],
            ['name' => 'Garuda Indonesia', 'code' => 'GA'],
            ['name' => 'Citilink', 'code' => 'QG'],
            ['name' => 'Lion Air', 'code' => 'JT'],
            ['name' => 'AirAsia Indonesia', 'code' => 'QZ'],
        ];

        foreach ($maskapais as $m) {
            Maskapai::firstOrCreate(['code' => $m['code']], $m);
        }

        $wilayahs = [
            ['city_name' => 'Banda Aceh', 'airport_code' => 'BTJ'],
            ['city_name' => 'Jakarta', 'airport_code' => 'CGK'],
            ['city_name' => 'Jakarta (Halim)', 'airport_code' => 'HLP'],
            ['city_name' => 'Medan', 'airport_code' => 'KNO'],
            ['city_name' => 'Surabaya', 'airport_code' => 'SUB'],
            ['city_name' => 'Denpasar', 'airport_code' => 'DPS'],
            ['city_name' => 'Yogyakarta', 'airport_code' => 'YIA'],
            ['city_name' => 'Makassar', 'airport_code' => 'UPG'],
        ];

        foreach ($wilayahs as $w) {
            Wilayah::firstOrCreate(['airport_code' => $w['airport_code']], $w);
        }
    }
}
