<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use App\Models\TourPackage;
use App\Models\Review;
use App\Models\SavedPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $regions = ['Bari', 'Nugaal', 'Mudug', 'Sanaag', 'Sool', 'Karkaar', 'Haylaan', 'Gardafuul'];

        $query = Destination::with('category');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('region')) {
            $query->where('region', $request->region);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $destinations = $query->latest()->limit(15)->get();

        $featuredTours = TourPackage::with('destination')->where('status', 'active')->limit(6)->get();
        $reviews = Review::with(['user', 'destination'])->where('is_approved', true)->latest()->limit(4)->get();

        // Sample Puntland weather dataset
        $weatherData = [
            'Bosaso' => ['temp' => '32°C', 'condition' => 'Sunny & Breezy', 'humidity' => '58%', 'wind' => '14 km/h'],
            'Garowe' => ['temp' => '28°C', 'condition' => 'Clear Skies', 'humidity' => '42%', 'wind' => '18 km/h'],
            'Eyl' => ['temp' => '26°C', 'condition' => 'Ocean Breeze', 'humidity' => '65%', 'wind' => '22 km/h'],
            'Cal Madow' => ['temp' => '21°C', 'condition' => 'Mountain Mist', 'humidity' => '72%', 'wind' => '10 km/h'],
            'Hafun' => ['temp' => '27°C', 'condition' => 'Coastal Sunshine', 'humidity' => '60%', 'wind' => '25 km/h'],
        ];

        return view('home', compact('categories', 'regions', 'destinations', 'featuredTours', 'reviews', 'weatherData'));
    }

    public function destinations(Request $request)
    {
        $categories = Category::all();
        $regions = ['Bari', 'Nugaal', 'Mudug', 'Sanaag', 'Sool', 'Karkaar', 'Haylaan', 'Gardafuul'];

        $query = Destination::with('category');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('region')) {
            $query->where('region', $request->region);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $destinations = $query->paginate(9);

        return view('destinations.index', compact('destinations', 'categories', 'regions'));
    }

    public function destinationShow($slug)
    {
        $destination = Destination::with(['category', 'tourPackages', 'reviews.user'])->where('slug', $slug)->firstOrFail();
        $relatedDestinations = Destination::where('category_id', $destination->category_id)->where('id', '!=', $destination->id)->limit(3)->get();
        
        $isSaved = false;
        if (Auth::check()) {
            $isSaved = SavedPlace::where('user_id', Auth::id())->where('destination_id', $destination->id)->exists();
        }

        return view('destinations.show', compact('destination', 'relatedDestinations', 'isSaved'));
    }

    public function map()
    {
        $destinations = Destination::with('category')->get();
        return view('map', compact('destinations'));
    }

    public function tours()
    {
        $tours = TourPackage::with('destination')->where('status', 'active')->paginate(6);
        return view('tours.index', compact('tours'));
    }

    public function tourShow($slug)
    {
        $tour = TourPackage::with('destination')->where('slug', $slug)->firstOrFail();
        return view('tours.show', compact('tour'));
    }

    public function culture()
    {
        return view('culture');
    }

    public function toggleSavePlace(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated', 'message' => 'Please login to save places.'], 401);
        }

        $user = Auth::user();
        $existing = SavedPlace::where('user_id', $user->id)->where('destination_id', $id)->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['status' => 'removed', 'message' => 'Destination removed from saved places.']);
        }

        SavedPlace::create([
            'user_id' => $user->id,
            'destination_id' => $id
        ]);

        return response()->json(['status' => 'saved', 'message' => 'Destination saved to your itinerary!']);
    }

    public function storeReview(Request $request, $destinationId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'destination_id' => $destinationId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true
        ]);

        return back()->with('success', 'Thank you! Your review has been submitted.');
    }

    public function searchCities(Request $request)
    {
        $query = trim($request->get('q', ''));
        
        // Comprehensive list of Puntland cities and regions
        $puntlandCities = [
            ['city' => 'Bosaso', 'region' => 'Bari', 'desc' => 'Port city & economic hub on the Gulf of Aden'],
            ['city' => 'Garowe', 'region' => 'Nugaal', 'desc' => 'Administrative capital of Puntland State'],
            ['city' => 'Galkacyo', 'region' => 'Mudug', 'desc' => 'Major trade and cultural crossroads'],
            ['city' => 'Eyl', 'region' => 'Nugaal', 'desc' => 'Historic Dervish stone forts & scenic ocean cliffs'],
            ['city' => 'Qandala', 'region' => 'Bari', 'desc' => 'Historic coastal frankincense trade port'],
            ['city' => 'Hafun', 'region' => 'Gardafuul', 'desc' => 'Africa\'s easternmost peninsula & ancient salt port'],
            ['city' => 'Raas Hafun', 'region' => 'Gardafuul', 'desc' => 'Easternmost point of Africa with pristine beaches'],
            ['city' => 'Cal Madow', 'region' => 'Sanaag', 'desc' => 'Mountain waterfalls & frankincense cloud forests'],
            ['city' => 'Erigavo', 'region' => 'Sanaag', 'desc' => 'Highland capital near Daallo forest'],
            ['city' => 'Badhan', 'region' => 'Sanaag', 'desc' => 'Historical mountain region center'],
            ['city' => 'Taleex', 'region' => 'Sool', 'desc' => 'Epicenter of Sayid Mohamed Dervish fortresses'],
            ['city' => 'Qardho', 'region' => 'Karkaar', 'desc' => 'Traditional cultural & historical capital of Karkaar'],
            ['city' => 'Las Khorey', 'region' => 'Sanaag', 'desc' => 'Ancient seaport famous for tuna fishing & historical sites'],
            ['city' => 'Burtinle', 'region' => 'Nugaal', 'desc' => 'Vibrant transit hub and pastoral landscape'],
            ['city' => 'Iskushuban', 'region' => 'Bari', 'desc' => 'Famous seasonal waterfalls & historical architecture'],
            ['city' => 'Bargaal', 'region' => 'Gardafuul', 'desc' => 'Historic coastal sultanate settlement'],
            ['city' => 'Alula', 'region' => 'Gardafuul', 'desc' => 'Guardafui lighthouse & maritime gateway'],
            ['city' => 'Bandar Bayla', 'region' => 'Karkaar', 'desc' => 'Indian Ocean coastal scenery & fishing haven'],
            ['city' => 'Dhahar', 'region' => 'Haylaan', 'desc' => 'Valleys, pastoral traditions, and mountain views'],
            ['city' => 'Ufeyn', 'region' => 'Bari', 'desc' => 'Freshwater mountain springs & date palm oases'],
        ];

        // Also query destinations from DB
        $dbDestinations = Destination::when($query, function($q) use ($query) {
            $q->where('city', 'like', "%{$query}%")
              ->orWhere('title', 'like', "%{$query}%")
              ->orWhere('region', 'like', "%{$query}%");
        })->get(['id', 'title', 'city', 'region', 'slug', 'featured_image', 'rating']);

        // Filter static cities list if query provided
        $filteredCities = array_values(array_filter($puntlandCities, function($item) use ($query) {
            if (empty($query)) return true;
            return (stripos($item['city'], $query) !== false || stripos($item['region'], $query) !== false || stripos($item['desc'], $query) !== false);
        }));

        return response()->json([
            'cities' => $filteredCities,
            'destinations' => $dbDestinations
        ]);
    }
}

