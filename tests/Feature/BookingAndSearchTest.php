<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TourPackage;
use App\Models\Booking;

class BookingAndSearchTest extends TestCase
{
    public function test_puntland_cities_search_api_returns_all_cities(): void
    {
        $response = $this->getJson('/api/cities/search');
        $response->assertStatus(200);
        $response->assertJsonStructure(['cities', 'destinations']);
        
        $cities = collect($response->json('cities'))->pluck('city')->all();
        $this->assertContains('Garowe', $cities);
        $this->assertContains('Bosaso', $cities);
        $this->assertContains('Eyl', $cities);
        $this->assertContains('Taleex', $cities);
    }

    public function test_user_can_submit_booking_with_full_details(): void
    {
        $user = User::where('role', 'tourist')->first() ?? User::factory()->create(['role' => 'tourist']);
        $tour = TourPackage::first();

        $response = $this->actingAs($user)->post('/bookings', [
            'tour_package_id' => $tour->id,
            'full_name' => 'Faadumo Cali Warsame',
            'email' => 'faadumo@example.com',
            'phone' => '+252907445566',
            'current_location' => 'Bosaso, Puntland',
            'emergency_contact' => '+252907001122',
            'travel_date' => now()->addDays(4)->toDateString(),
            'number_of_guests' => 3,
            'special_requests' => 'Family group, near beach accommodation'
        ]);

        $response->assertRedirect('/my-dashboard');

        $this->assertDatabaseHas('bookings', [
            'full_name' => 'Faadumo Cali Warsame',
            'current_location' => 'Bosaso, Puntland',
            'phone' => '+252907445566',
            'email' => 'faadumo@example.com',
            'number_of_guests' => 3
        ]);
    }

    public function test_admin_can_reject_booking_with_reason(): void
    {
        $admin = User::where('role', 'admin')->first();
        $booking = Booking::latest()->first();

        $response = $this->actingAs($admin)->post('/admin/bookings/' . $booking->id . '/reject', [
            'rejection_reason' => 'Booking date overlaps with maintenance closure.'
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'rejected',
            'rejection_reason' => 'Booking date overlaps with maintenance closure.'
        ]);
    }

    public function test_admin_can_edit_and_modify_booking(): void
    {
        $admin = User::where('role', 'admin')->first();
        $booking = Booking::latest()->first();
        $tour = TourPackage::first();

        $response = $this->actingAs($admin)->put('/admin/bookings/' . $booking->id, [
            'tour_package_id' => $tour->id,
            'full_name' => 'Maxamed Cabdi Jaamac',
            'email' => 'maxamed@example.com',
            'phone' => '+252907998877',
            'current_location' => 'Garowe, Puntland',
            'emergency_contact' => '+252907112233',
            'travel_date' => now()->addDays(7)->toDateString(),
            'number_of_guests' => 4,
            'total_price' => 950.00,
            'special_requests' => 'Updated requests',
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'rejection_reason' => null
        ]);

        $response->assertRedirect('/admin/bookings');

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'full_name' => 'Maxamed Cabdi Jaamac',
            'current_location' => 'Garowe, Puntland',
            'status' => 'confirmed',
            'payment_status' => 'paid'
        ]);
    }
}
