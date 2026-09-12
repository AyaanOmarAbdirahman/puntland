<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Destination;
use App\Models\TourPackage;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $totalRevenue = Booking::where('status', 'confirmed')->orWhere('payment_status', 'paid')->sum('total_price');
        $totalDestinations = Destination::count();
        $totalTours = TourPackage::count();
        $totalTourists = User::where('role', 'tourist')->count();

        $recentBookings = Booking::with(['user', 'tourPackage.destination'])->latest()->limit(5)->get();
        $topDestinations = Destination::withCount('tourPackages')->orderBy('rating', 'desc')->limit(4)->get();

        return view('admin.dashboard', compact(
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'totalRevenue',
            'totalDestinations',
            'totalTours',
            'totalTourists',
            'recentBookings',
            'topDestinations'
        ));
    }

    // --- Destination CRUD ---
    public function destinations()
    {
        $destinations = Destination::with('category')->latest()->paginate(10);
        return view('admin.destinations.index', compact('destinations'));
    }

    public function createDestination()
    {
        $categories = Category::all();
        $regions = ['Bari', 'Nugaal', 'Mudug', 'Sanaag', 'Sool', 'Karkaar', 'Haylaan', 'Gardafuul'];
        return view('admin.destinations.create', compact('categories', 'regions'));
    }

    public function storeDestination(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'region' => 'required|string',
            'city' => 'required|string',
            'description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'entry_fee' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:4096',
            'best_season' => 'nullable|string'
        ]);

        $imagePath = 'images/destinations/bosaso_port.jpg'; // default fallback
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('destinations', 'public');
            $imagePath = 'storage/' . $path;
        }

        Destination::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(4),
            'region' => $request->region,
            'city' => $request->city,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured_image' => $imagePath,
            'entry_fee' => $request->entry_fee,
            'rating' => 4.9,
            'is_featured' => $request->has('is_featured'),
            'best_season' => $request->best_season
        ]);

        return redirect()->route('admin.destinations')->with('success', 'Destination created successfully!');
    }

    public function editDestination($id)
    {
        $destination = Destination::findOrFail($id);
        $categories = Category::all();
        $regions = ['Bari', 'Nugaal', 'Mudug', 'Sanaag', 'Sool', 'Karkaar', 'Haylaan', 'Gardafuul'];
        return view('admin.destinations.edit', compact('destination', 'categories', 'regions'));
    }

    public function updateDestination(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'region' => 'required|string',
            'city' => 'required|string',
            'description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'entry_fee' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:4096',
            'best_season' => 'nullable|string'
        ]);

        $imagePath = $destination->featured_image;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('destinations', 'public');
            $imagePath = 'storage/' . $path;
        }

        $destination->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'region' => $request->region,
            'city' => $request->city,
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'featured_image' => $imagePath,
            'entry_fee' => $request->entry_fee,
            'is_featured' => $request->has('is_featured'),
            'best_season' => $request->best_season
        ]);

        return redirect()->route('admin.destinations')->with('success', 'Destination updated successfully!');
    }

    public function deleteDestination($id)
    {
        $destination = Destination::findOrFail($id);
        $destination->delete();
        return redirect()->route('admin.destinations')->with('success', 'Destination deleted successfully!');
    }

    // --- Tour Package CRUD ---
    public function tours()
    {
        $tours = TourPackage::with('destination')->latest()->paginate(10);
        return view('admin.tours.index', compact('tours'));
    }

    public function createTour()
    {
        $destinations = Destination::all();
        return view('admin.tours.create', compact('destinations'));
    }

    public function storeTour(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'title' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price_per_person' => 'required|numeric|min:0',
            'max_capacity' => 'required|integer|min:1',
            'start_date' => 'nullable|date'
        ]);

        TourPackage::create([
            'destination_id' => $request->destination_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(4),
            'duration_days' => $request->duration_days,
            'price_per_person' => $request->price_per_person,
            'max_capacity' => $request->max_capacity,
            'included_services' => explode(',', $request->included_services ?? 'Accommodation,Guided Tour,Transfers'),
            'start_date' => $request->start_date,
            'status' => 'active'
        ]);

        return redirect()->route('admin.tours')->with('success', 'Tour Package created successfully!');
    }

    public function editTour($id)
    {
        $tour = TourPackage::findOrFail($id);
        $destinations = Destination::all();
        return view('admin.tours.edit', compact('tour', 'destinations'));
    }

    public function updateTour(Request $request, $id)
    {
        $tour = TourPackage::findOrFail($id);

        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'title' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price_per_person' => 'required|numeric|min:0',
            'max_capacity' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'status' => 'required|string'
        ]);

        $tour->update([
            'destination_id' => $request->destination_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'duration_days' => $request->duration_days,
            'price_per_person' => $request->price_per_person,
            'max_capacity' => $request->max_capacity,
            'included_services' => is_array($request->included_services) ? $request->included_services : explode(',', $request->included_services),
            'start_date' => $request->start_date,
            'status' => $request->status
        ]);

        return redirect()->route('admin.tours')->with('success', 'Tour Package updated successfully!');
    }

    public function deleteTour($id)
    {
        $tour = TourPackage::findOrFail($id);
        $tour->delete();
        return redirect()->route('admin.tours')->with('success', 'Tour Package deleted successfully!');
    }

    // --- Bookings Management ---
    public function bookings()
    {
        $bookings = Booking::with(['user', 'tourPackage.destination'])->latest()->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function editBooking($id)
    {
        $booking = Booking::with(['user', 'tourPackage.destination'])->findOrFail($id);
        $tourPackages = TourPackage::with('destination')->where('status', 'active')->get();
        return view('admin.bookings.edit', compact('booking', 'tourPackages'));
    }

    public function updateBooking(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'tour_package_id' => 'required|exists:tour_packages,id',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'current_location' => 'required|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'travel_date' => 'required|date',
            'number_of_guests' => 'required|integer|min:1|max:50',
            'total_price' => 'required|numeric|min:0',
            'special_requests' => 'nullable|string|max:1000',
            'rejection_reason' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,confirmed,completed,cancelled,rejected',
            'payment_status' => 'required|in:unpaid,paid'
        ]);

        $booking->update([
            'tour_package_id' => $request->tour_package_id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'current_location' => $request->current_location,
            'emergency_contact' => $request->emergency_contact,
            'travel_date' => $request->travel_date,
            'number_of_guests' => $request->number_of_guests,
            'total_price' => $request->total_price,
            'special_requests' => $request->special_requests,
            'rejection_reason' => $request->status === 'rejected' ? $request->rejection_reason : ($request->rejection_reason ?? $booking->rejection_reason),
            'status' => $request->status,
            'payment_status' => $request->payment_status
        ]);

        // Send notification to user
        if ($booking->user_id) {
            Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Booking #' . $booking->booking_code . ' Updated',
                'message' => 'Your booking details and status have been updated by admin to: ' . ucfirst($booking->status),
                'type' => 'booking'
            ]);
        }

        return redirect()->route('admin.bookings')->with('success', 'Booking #' . $booking->booking_code . ' modified and updated successfully!');
    }

    public function rejectBooking(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        $bookingCode = $booking->booking_code;
        $userId = $booking->user_id;
        $reason = $request->rejection_reason;

        // Notify tourist before deleting
        if ($userId) {
            Notification::create([
                'user_id' => $userId,
                'title' => 'Booking #' . $bookingCode . ' Rejected',
                'message' => 'Unfortunately, your tour booking #' . $bookingCode . ' was rejected and removed. Reason: ' . $reason,
                'type' => 'booking'
            ]);
        }

        // Automatically delete from database
        $booking->delete();

        return back()->with('success', 'Booking #' . $bookingCode . ' has been rejected and automatically removed from the database.');
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled,rejected',
            'payment_status' => 'required|in:unpaid,paid',
            'rejection_reason' => 'nullable|string|max:1000'
        ]);

        $updateData = [
            'status' => $request->status,
            'payment_status' => $request->payment_status
        ];

        if ($request->status === 'rejected' && $request->filled('rejection_reason')) {
            $updateData['rejection_reason'] = $request->rejection_reason;
        }

        $booking->update($updateData);

        if ($booking->user_id) {
            Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Booking #' . $booking->booking_code . ' Status Changed',
                'message' => 'Your booking status is now ' . ucfirst($request->status) . ($request->status === 'rejected' && $booking->rejection_reason ? '. Reason: ' . $booking->rejection_reason : ''),
                'type' => 'booking'
            ]);
        }

        return back()->with('success', 'Booking #' . $booking->booking_code . ' updated successfully!');
    }
}

