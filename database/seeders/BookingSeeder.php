<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Accommodation;
use App\Models\Vehicle;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get tourist user
        $tourist = User::where('role', 'tourist')->first();

        if (!$tourist) {
            return;
        }

        // Get some accommodations and vehicles
        $accommodations = Accommodation::take(2)->get();
        $vehicles = Vehicle::take(2)->get();

        // Create sample bookings
        $bookings = [
            [
                'tourist_id' => $tourist->id,
                'item_type' => 'accommodation',
                'item_id' => $accommodations->first()->id ?? 1,
                'start_date' => '2025-08-10',
                'end_date' => '2025-08-15',
                'status' => 'confirmed',
            ],
            [
                'tourist_id' => $tourist->id,
                'item_type' => 'vehicle',
                'item_id' => $vehicles->first()->id ?? 1,
                'start_date' => '2025-08-10',
                'end_date' => '2025-08-13',
                'status' => 'pending',
            ],
            [
                'tourist_id' => $tourist->id,
                'item_type' => 'vehicle',
                'item_id' => $vehicles->last()->id ?? 2,
                'start_date' => '2025-06-05',
                'end_date' => '2025-06-26',
                'status' => 'confirmed',
            ],
        ];

        foreach ($bookings as $bookingData) {
            Booking::create($bookingData);
        }
    }
}
