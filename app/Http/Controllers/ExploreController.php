<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\TourPackage;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    // Comprehensive Puntland cities map with metadata in English
    private array $cities = [
        'garowe' => [
            'name' => 'Garowe',
            'region' => 'Nugaal',
            'category' => 'urban',
            'tag' => 'Capital City',
            'desc' => 'Garowe is the administrative capital of Puntland State — the political, economic, cultural, and modern administrative heart of the region.',
            'image' => 'images/cities/garowe.jpg',
            'icon' => 'fa-building-columns',
        ],
        'bosaso' => [
            'name' => 'Bosaso',
            'region' => 'Bari',
            'category' => 'coastal',
            'tag' => 'Commercial Port & Trade',
            'desc' => 'Bosaso is the largest commercial hub and premier seaport of Puntland on the Gulf of Aden, famous for its vibrant markets and sandy coastline.',
            'image' => 'images/cities/bosaso.jpg',
            'icon' => 'fa-ship',
        ],
        'galkacyo' => [
            'name' => 'Galkacyo',
            'region' => 'Mudug',
            'category' => 'urban',
            'tag' => 'Trade & Livestock Hub',
            'desc' => 'Galkacyo is the economic center of the Mudug region and a major crossroads connecting central and northern Somalia, renowned for trade and poetry.',
            'image' => 'images/cities/garowe.jpg',
            'icon' => 'fa-city',
        ],
        'eyl' => [
            'name' => 'Eyl',
            'region' => 'Nugaal',
            'category' => 'coastal',
            'tag' => 'Historic Forts & Coast',
            'desc' => 'Eyl is a historic coastal town celebrated for its Dervish stone castles, picturesque Indian Ocean cliffs, scenic fishing valleys, and tranquil beaches.',
            'image' => 'images/cities/eyl.jpg',
            'icon' => 'fa-fort-awesome',
        ],
        'qandala' => [
            'name' => 'Qandala',
            'region' => 'Bari',
            'category' => 'coastal',
            'tag' => 'Frankincense & Beaches',
            'desc' => 'Qandala is an ancient Gulf of Aden coastal sanctuary renowned for its crystal turquoise waters, mountain hiking routes, and frankincense groves.',
            'image' => 'images/cities/qandala.jpg',
            'icon' => 'fa-water',
        ],
        'hafun' => [
            'name' => 'Hafun',
            'region' => 'Gardafuul',
            'category' => 'coastal',
            'tag' => 'Easternmost Horn of Africa',
            'desc' => 'Hafun is a historic peninsula jutting into the Indian Ocean, rich in ancient maritime heritage, pristine fisheries, and scenic ocean views.',
            'image' => 'images/cities/hafun.jpg',
            'icon' => 'fa-umbrella-beach',
        ],
        'raas-hafun' => [
            'name' => 'Raas Hafun',
            'region' => 'Gardafuul',
            'category' => 'coastal',
            'tag' => 'Easternmost Point of Africa',
            'desc' => 'Raas Hafun is the easternmost continental tip of Africa, offering dramatic marine landscapes, unique coastal biodiversity, and historical landmarks.',
            'image' => 'images/cities/raas-hafun.jpg',
            'icon' => 'fa-compass',
        ],
        'kabal-haafuun' => [
            'name' => 'Kabal Haafuun',
            'region' => 'Gardafuul',
            'category' => 'coastal',
            'tag' => 'Pristine Coastal Haven',
            'desc' => 'Kabal Haafuun is an authentic coastal village nestled along the peninsula, featuring crystal clear waters, ocean breezes, and serene serenity.',
            'image' => 'images/cities/kabal-haafuun.jpg',
            'icon' => 'fa-anchor',
        ],
        'cal-madow' => [
            'name' => 'Cal Madow',
            'region' => 'Sanaag',
            'category' => 'mountain',
            'tag' => 'Mountain Highlands & Waterfalls',
            'desc' => 'Cal Madow is an iconic mountain range boasting lush highland forests, cool mist, natural waterfalls, rich wildlife, and rare flora species.',
            'image' => 'images/destinations/cal_madow.jpg',
            'icon' => 'fa-mountain-sun',
        ],
        'erigavo' => [
            'name' => 'Erigavo',
            'region' => 'Sanaag',
            'category' => 'mountain',
            'tag' => 'Highland Valley Capital',
            'desc' => 'Erigavo sits elevated in the cool highlands of Sanaag, gateway to the Cal Madow mountain trails, cedar tree canopies, and scenic peaks.',
            'image' => 'images/cities/erigavo.jpg',
            'icon' => 'fa-tree',
        ],
        'taleex' => [
            'name' => 'Taleex',
            'region' => 'Sool',
            'category' => 'historic',
            'tag' => 'Dervish Historic Capital',
            'desc' => 'Taleex is the historic capital of the Dervish State, home to monumental stone fortresses including Silsilad, Falxa, Daawad, and Hed-Kaad.',
            'image' => 'images/destinations/eyl_castle.jpg',
            'icon' => 'fa-landmark',
        ],
        'qardho' => [
            'name' => 'Qardho',
            'region' => 'Karkaar',
            'category' => 'historic',
            'tag' => 'Royal Heritage & Culture',
            'desc' => 'Qardho is the traditional cultural and royal capital of the Karkaar region, celebrated for Somali poetry, heritage architecture, and royal traditions.',
            'image' => 'images/cities/garowe.jpg',
            'icon' => 'fa-monument',
        ],
        'badhan' => [
            'name' => 'Badhan',
            'region' => 'Sanaag',
            'category' => 'mountain',
            'tag' => 'Highland Valleys & Springs',
            'desc' => 'Badhan (Baran) is located in eastern Sanaag surrounded by lush valleys, cool mountain climates, fertile soil, and natural freshwater springs.',
            'image' => 'images/destinations/cal_madow.jpg',
            'icon' => 'fa-mountain',
        ],
        'las-khorey' => [
            'name' => 'Las Khorey',
            'region' => 'Sanaag',
            'category' => 'coastal',
            'tag' => 'Ancient Seaport & Fisheries',
            'desc' => 'Las Khorey is an ancient maritime trade port on the Gulf of Aden, famous for its renowned tuna fishing heritage and white sandy beaches.',
            'image' => 'images/destinations/qandala_coast.jpg',
            'icon' => 'fa-fish',
        ],
        'iskushuban' => [
            'name' => 'Iskushuban',
            'region' => 'Bari',
            'category' => 'historic',
            'tag' => 'Natural Waterfalls & Oases',
            'desc' => 'Iskushuban is famed for its seasonal waterfalls, picturesque date palm riverbeds, historic stone architecture, and serene canyon walks.',
            'image' => 'images/destinations/bosaso_port.jpg',
            'icon' => 'fa-droplet',
        ],
    ];

    /**
     * Explore overview — show all city cards with dynamic destination & tour counts.
     */
    public function index()
    {
        $cities = $this->cities;

        foreach ($cities as $slug => &$city) {
            $cityName = $city['name'];
            $destCount = Destination::where(function($q) use ($cityName) {
                $q->where('city', $cityName)
                  ->orWhere('city', 'like', "%{$cityName}%")
                  ->orWhere('title', 'like', "%{$cityName}%");
            })->count();

            $pkgCount = TourPackage::whereHas('destination', function($q) use ($cityName) {
                $q->where('city', $cityName)
                  ->orWhere('city', 'like', "%{$cityName}%")
                  ->orWhere('title', 'like', "%{$cityName}%");
            })->where('status', 'active')->count();

            $minPrice = TourPackage::whereHas('destination', function($q) use ($cityName) {
                $q->where('city', $cityName)
                  ->orWhere('city', 'like', "%{$cityName}%")
                  ->orWhere('title', 'like', "%{$cityName}%");
            })->where('status', 'active')->min('price_per_person');

            $city['dest_count'] = $destCount;
            $city['pkg_count'] = $pkgCount;
            $city['starting_price'] = $minPrice ? (float)$minPrice : 55.00;
        }

        return view('explore.index', compact('cities'));
    }

    /**
     * City detail page — show all tour packages and destinations for this city.
     */
    public function city(string $slug)
    {
        if (!array_key_exists($slug, $this->cities)) {
            abort(404);
        }

        $cityData = $this->cities[$slug];
        $cityName = $cityData['name'];

        // Fetch destinations belonging to this city
        $destinations = Destination::with('tourPackages')
            ->where(function($q) use ($cityName) {
                $q->where('city', $cityName)
                  ->orWhere('city', 'like', "%{$cityName}%")
                  ->orWhere('title', 'like', "%{$cityName}%");
            })
            ->get();

        // Fetch all packages directly for this city
        $packages = TourPackage::with('destination')
            ->whereHas('destination', function($q) use ($cityName) {
                $q->where('city', $cityName)
                  ->orWhere('city', 'like', "%{$cityName}%")
                  ->orWhere('title', 'like', "%{$cityName}%");
            })
            ->where('status', 'active')
            ->get();

        return view('explore.city', compact('cityName', 'slug', 'cityData', 'destinations', 'packages'));
    }
}
