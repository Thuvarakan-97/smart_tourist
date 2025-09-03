<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accommodation;

class AccommodationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Accommodation::create([
            'owner_id' => 3, // Kavindu Silva (room_owner)
            'dest_id' => 1, // Sigiriya
            'title' => 'Sigiriya View Hotel',
            'description' => 'Beautiful guest house near Sigiriya.',
            'price_per_night' => 7500.00,
            'image_url' => 'images/hotel1.jpg',
            'available_from' => '2025-07-01',
            'available_to' => '2025-12-31',
        ]);

        Accommodation::create([
            'owner_id' => 3, // Kavindu Silva (room_owner)
            'dest_id' => 3, // Ella
            'title' => 'Ella Paradise Inn',
            'description' => 'Affordable rooms with mountain views.',
            'price_per_night' => 5500.00,
            'image_url' => 'images/hotel2.jpg',
            'available_from' => '2025-06-15',
            'available_to' => '2025-10-30',
        ]);
    }
}
