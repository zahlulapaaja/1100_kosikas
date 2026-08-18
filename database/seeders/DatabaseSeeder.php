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
            ['name' => 'Super Air Jet', 'code_iata' => 'IU', 'code_icao' => 'SJV'],
            ['name' => 'Garuda Indonesia', 'code_iata' => 'GA', 'code_icao' => 'GIA'],
            ['name' => 'Citilink', 'code_iata' => 'QG', 'code_icao' => 'CTV'],
            ['name' => 'Lion Air', 'code_iata' => 'JT', 'code_icao' => 'LNI'],
            ['name' => 'AirAsia Indonesia', 'code_iata' => 'QZ', 'code_icao' => 'AWQ'],
            ['name' => 'Batik Air', 'code_iata' => 'ID', 'code_icao' => 'BTK'],
            ['name' => 'Wings Air', 'code_iata' => 'IW', 'code_icao' => 'WON'],
            ['name' => 'Pelita Air', 'code_iata' => 'IP', 'code_icao' => 'PAS'],
            ['name' => 'Sriwijaya Air', 'code_iata' => 'SJ', 'code_icao' => 'SJY'],
            ['name' => 'NAM Air', 'code_iata' => 'IN', 'code_icao' => 'LKN'],
            ['name' => 'TransNusa', 'code_iata' => '8B', 'code_icao' => 'TNU'],
            ['name' => 'Trigana Air', 'code_iata' => 'IL', 'code_icao' => 'TGN'],
            ['name' => 'Susi Air', 'code_iata' => 'SI', 'code_icao' => 'SQS'],
        ];

        foreach ($maskapais as $m) {
            Maskapai::firstOrCreate(['code_iata' => $m['code_iata']], $m);
        }

        $wilayahs = [
            ['airport_name' => 'Sultan Iskandar Muda International Airport', 'code_iata' => 'BTJ', 'code_icao' => 'WITT', 'city_name' => 'Banda Aceh', 'province_name' => 'Aceh', 'country' => 'Indonesia', 'latitude' => 5.5229, 'longitude' => 95.4200, 'is_active' => true],
            ['airport_name' => 'Soekarno-Hatta International Airport', 'code_iata' => 'CGK', 'code_icao' => 'WIII', 'city_name' => 'Jakarta', 'province_name' => 'Banten', 'country' => 'Indonesia', 'latitude' => -6.1256, 'longitude' => 106.6559, 'is_active' => true],
            ['airport_name' => 'Halim Perdanakusuma International Airport', 'code_iata' => 'HLP', 'code_icao' => 'WIHH', 'city_name' => 'Jakarta', 'province_name' => 'DKI Jakarta', 'country' => 'Indonesia', 'latitude' => -6.2666, 'longitude' => 106.8900, 'is_active' => true],
            ['airport_name' => 'Kualanamu International Airport', 'code_iata' => 'KNO', 'code_icao' => 'WIMM', 'city_name' => 'Medan', 'province_name' => 'Sumatera Utara', 'country' => 'Indonesia', 'latitude' => 3.6422, 'longitude' => 98.8853, 'is_active' => true],
            ['airport_name' => 'Juanda International Airport', 'code_iata' => 'SUB', 'code_icao' => 'WARR', 'city_name' => 'Surabaya', 'province_name' => 'Jawa Timur', 'country' => 'Indonesia', 'latitude' => -7.3798, 'longitude' => 112.7870, 'is_active' => true],
            ['airport_name' => 'I Gusti Ngurah Rai International Airport', 'code_iata' => 'DPS', 'code_icao' => 'WADD', 'city_name' => 'Denpasar', 'province_name' => 'Bali', 'country' => 'Indonesia', 'latitude' => -8.7482, 'longitude' => 115.1672, 'is_active' => true],
            ['airport_name' => 'Yogyakarta International Airport', 'code_iata' => 'YIA', 'code_icao' => 'WAHI', 'city_name' => 'Yogyakarta', 'province_name' => 'DI Yogyakarta', 'country' => 'Indonesia', 'latitude' => -7.9053, 'longitude' => 110.0570, 'is_active' => true],
            ['airport_name' => 'Sultan Hasanuddin International Airport', 'code_iata' => 'UPG', 'code_icao' => 'WAAA', 'city_name' => 'Makassar', 'province_name' => 'Sulawesi Selatan', 'country' => 'Indonesia', 'latitude' => -5.0616, 'longitude' => 119.5540, 'is_active' => true],
            ['airport_name' => 'Lasikin Airport', 'code_iata' => 'LKI', 'code_icao' => 'WITG', 'city_name' => 'Simeulue', 'province_name' => 'Aceh', 'country' => 'Indonesia', 'latitude' => 2.4100, 'longitude' => 96.3250, 'is_active' => true],
            ['airport_name' => 'Cut Nyak Dhien Airport', 'code_iata' => 'MEQ', 'code_icao' => 'WITC', 'city_name' => 'Meulaboh', 'province_name' => 'Aceh', 'country' => 'Indonesia', 'latitude' => 4.0407, 'longitude' => 96.2576, 'is_active' => true],
            ['airport_name' => 'Malikussaleh Airport', 'code_iata' => 'LSW', 'code_icao' => 'WITM', 'city_name' => 'Lhokseumawe', 'province_name' => 'Aceh', 'country' => 'Indonesia', 'latitude' => 5.2267, 'longitude' => 96.9503, 'is_active' => true],
            ['airport_name' => 'Maimun Saleh Airport', 'code_iata' => 'SBG', 'code_icao' => 'WITB', 'city_name' => 'Sabang', 'province_name' => 'Aceh', 'country' => 'Indonesia', 'latitude' => 5.8740, 'longitude' => 95.3397, 'is_active' => true],
            ['airport_name' => 'Rembele Airport', 'code_iata' => 'TXE', 'code_icao' => 'WITK', 'city_name' => 'Takengon', 'province_name' => 'Aceh', 'country' => 'Indonesia', 'latitude' => 4.7213, 'longitude' => 96.8512, 'is_active' => true],
        ];

        foreach ($wilayahs as $w) {
            Wilayah::firstOrCreate(['code_iata' => $w['code_iata']], $w);
        }

        $this->call(DefaultUserSeeder::class);
    }
}
