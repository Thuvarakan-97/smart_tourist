<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Destination::create([
            'name' => 'Sigiriya Rock Fortress',
            'description' => 'Historic rock fortress with panoramic views.',
            'image_url' => 'images/sigiriya.jpeg',
            'rating' => 4.8,
            'latitude' => 7.957000,
            'longitude' => 80.760300,
        ]);

        Destination::create([
            'name' => 'Galle Fort',
            'description' => 'Colonial fort and UNESCO heritage site.',
            'image_url' => 'images/gallefort.jpg',
            'rating' => 4.6,
            'latitude' => 6.026600,
            'longitude' => 80.217000,
        ]);

        Destination::create([
            'name' => 'Ella',
            'description' => 'Hiking paradise with stunning scenery.',
            'image_url' => 'images/ella.jpg',
            'rating' => 4.7,
            'latitude' => 6.875400,
            'longitude' => 81.046000,
        ]);
    }
}
