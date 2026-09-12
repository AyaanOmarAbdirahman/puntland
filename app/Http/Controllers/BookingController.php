<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TourPackage;
use App\Models\Notification;
use App\Models\SavedPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tour_package_id' => 'required|exists:tour_packages,id',
            'full_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'current_location' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'travel_date' => 'required|date|after_or_equal:today',
            'number_of_guests' => 'required|integer|min:1|max:50',
            'special_requests' => 'nullable|string|max:1000'
        ]);

        $tour = TourPackage::with('destination')->findOrFail($request->tour_package_id);
        $totalPrice = $tour->price_per_person * $request->number_of_guests;

        $user = Auth::user();
        $fullName = trim($request->full_name ?: ($user ? $user->name : 'Tourist Traveler'));
        $email = trim($request->email ?: ($user ? $user->email : 'tourist@example.com'));
        $phone = trim($request->phone ?: ($user && $user->phone ? $user->phone : '+252 90 700 0000'));
        $currentLocation = trim($request->current_location ?: ($tour->destination ? $tour->destination->city : 'Puntland'));

        $booking = Booking::create([
            'booking_code' => 'PNT-' . strtoupper(Str::random(6)),
            'user_id' => Auth::id(),
            'tour_package_id' => $tour->id,
            'full_name' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'current_location' => $currentLocation,
            'emergency_contact' => $request->emergency_contact,
            'travel_date' => $request->travel_date,
            'number_of_guests' => $request->number_of_guests,
            'total_price' => $totalPrice,
            'special_requests' => $request->special_requests,
            'status' => 'pending',
            'payment_status' => 'unpaid'
        ]);

        // Create notification for admin
        Notification::create([
            'user_id' => null, // Broadcast to admin
            'title' => 'New Tour Package Booking',
            'message' => $fullName . ' booked ' . $tour->title . ' for ' . $request->number_of_guests . ' guest(s). Location: ' . $currentLocation . ', Phone: ' . $phone . '. Code: ' . $booking->booking_code,
            'type' => 'booking'
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Booking submitted successfully! Code: ' . $booking->booking_code . '. We will contact you shortly.');
    }

    public function userDashboard()
    {
        $user = Auth::user();
        $bookings = Booking::with(['tourPackage.destination'])->where('user_id', $user->id)->latest()->get();
        $savedPlaces = SavedPlace::with('destination.category')->where('user_id', $user->id)->get();

        return view('user.dashboard', compact('bookings', 'savedPlaces'));
    }

    public function cancel($id)
    {
        $booking = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($booking->status === 'cancelled') {
            return back()->with('info', 'Booking is already cancelled.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Your booking has been cancelled.');
    }
}
