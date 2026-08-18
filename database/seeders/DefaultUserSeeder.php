<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Buat satu user default untuk keperluan login/demo.
     * Menggunakan model User bawaan Laravel (migration default: name, email, password).
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kosikas.test'],
            [
                'name'              => 'Admin Kosikas Travel',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
