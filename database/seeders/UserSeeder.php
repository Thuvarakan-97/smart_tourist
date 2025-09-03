<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'token' => '058864b0613f71b62fd83c4d505a5009b88d2582367cc1d0041d5bc117939b7f',
        ]);

        // Tourist
        User::create([
            'name' => 'Amal Perera',
            'email' => 'amal@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'tourist',
            'token' => 'ba96aaeed8c14db806a1e7aba0ee551ac44effbf2fcee3792eff025a227d046d',
        ]);

        // Room Owner
        User::create([
            'name' => 'Kavindu Silva',
            'email' => 'kavindu@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'room_owner',
            'token' => '32fed08ea560e4539fd1edb47a801f8e51c192e5acde60eab0237be120bf0bd5',
        ]);

        // Vehicle Owner
        User::create([
            'name' => 'Rashmi Nilanthi',
            'email' => 'rashmi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'vehicle_owner',
            'token' => 'f24836bd14889810e4ea19cbdabce65cf1d0bf89ac4daf1e965e835c45526898',
        ]);

        // Another Vehicle Owner
        User::create([
            'name' => 'Kayathiri',
            'email' => 'kayathiri@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'vehicle_owner',
            'token' => 'd3c349be547fde7b32ac6d4ab51b74869e870bf06b2fcd2e9aba97b4436ccca8',
        ]);
    }
}
