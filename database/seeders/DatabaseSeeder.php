<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Notification;
use App\Models\SavedPlace;
use App\Models\Destination;
use App\Models\TourPackage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin & User
        $admin = User::firstOrCreate(
            ['email' => 'admin@tourism.gov.so'],
            [
                'name' => 'Puntland Tourism Authority Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '+252 90 779 0001',
                'avatar' => 'https://ui-avatars.com/api/?name=Puntland+Admin&background=0a192f&color=fff'
            ]
        );

        $tourist = User::firstOrCreate(
            ['email' => 'tourist@example.com'],
            [
                'name' => 'Jamaal Hassan',
                'password' => Hash::make('password123'),
                'role' => 'tourist',
                'phone' => '+252 90 712 3456',
                'avatar' => 'https://ui-avatars.com/api/?name=Jamaal+Hassan&background=00b4d8&color=fff'
            ]
        );

        // Call the external seeder that handles Destinations & Tour Packages properly
        $this->call(CityPackagesSeeder::class);

        // 5. Create Sample Booking (ensure destination and package exist)
        $p1 = TourPackage::first();
        if ($p1) {
            Booking::firstOrCreate(
                ['booking_code' => 'PNT-' . strtoupper(Str::random(6))],
                [
                    'user_id' => $tourist->id,
                    'tour_package_id' => $p1->id,
                    'full_name' => $tourist->name,
                    'email' => $tourist->email,
                    'phone' => $tourist->phone ?? '+252 90 712 3456',
                    'current_location' => 'Garowe, Puntland',
                    'travel_date' => now()->addDays(10)->toDateString(),
                    'number_of_guests' => 2,
                    'total_price' => $p1->price_per_person * 2,
                    'special_requests' => 'Vegetarian meal options required during the tour.',
                    'status' => 'confirmed',
                    'payment_status' => 'paid'
                ]
            );
        }
    }
}
