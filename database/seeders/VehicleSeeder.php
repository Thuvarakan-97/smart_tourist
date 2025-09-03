<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicle::create([
            'owner_id' => 3, // Kavindu Silva (also has vehicles)
            'type' => 'car',
            'description' => 'Comfortable A/C car with driver.',
            'price_per_day' => 9500.00,
            'image_url' => 'images/car.jpg',
            'available_from' => '2025-06-01',
            'available_to' => '2025-12-31',
        ]);

        Vehicle::create([
            'owner_id' => 3, // Kavindu Silva
            'type' => 'tuk-tuk',
            'description' => 'Fun local tuk-tuk rental, self-drive.',
            'price_per_day' => 2500.00,
            'image_url' => 'images/tuktuk.jpg',
            'available_from' => '2025-06-01',
            'available_to' => '2025-08-31',
        ]);

        Vehicle::create([
            'owner_id' => 4, // Rashmi Nilanthi (vehicle_owner)
            'type' => 'van',
            'description' => 'Spacious van for group tours.',
            'price_per_day' => 909.00,
            'image_url' => 'images/van.jpeg',
            'available_from' => '2025-05-29',
            'available_to' => '2025-06-03',
        ]);
    }
}
