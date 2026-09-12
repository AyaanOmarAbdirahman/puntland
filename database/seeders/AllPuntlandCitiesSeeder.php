<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Destination;
use App\Models\TourPackage;
use Illuminate\Support\Str;

class AllPuntlandCitiesSeeder extends Seeder
{
    public function run(): void
    {
        $catCity = Category::firstOrCreate(['slug' => 'modern-cities'], [
            'name' => 'Modern Cities & Cultural Heritage',
            'icon' => 'fa-city',
            'description' => 'Vibrant urban centers, traditional markets, state monuments, and Somali cuisine.'
        ]);

        $catFort = Category::firstOrCreate(['slug' => 'historical-forts'], [
            'name' => 'Historical Forts & Castles',
            'icon' => 'fa-fort-awesome',
            'description' => 'Centuries-old stone fortresses, Dervish castles, and ancient frankincense trading ports.'
        ]);

        $catBeach = Category::firstOrCreate(['slug' => 'coastal-beaches'], [
            'name' => 'Coastal & Beaches',
            'icon' => 'fa-umbrella-beach',
            'description' => 'Turquoise ocean water, white sand beaches, and marine life across the Gulf of Aden & Indian Ocean.'
        ]);

        $catMountain = Category::firstOrCreate(['slug' => 'mountain-ranges'], [
            'name' => 'Mountain Ranges & Valleys',
            'icon' => 'fa-mountain',
            'description' => 'Cool mountain elevations, natural waterfalls, frankincense forests, and hiking canyons.'
        ]);

        $citiesData = [
            [
                'title' => 'Galkacyo Cultural & Historic Hub (Mudug)',
                'slug' => 'galkacyo-mudug-hub',
                'region' => 'Mudug',
                'city' => 'Galkacyo',
                'category_id' => $catCity->id,
                'description' => 'Magaalada Galkacyo waa xarunta gobolka Mudug iyo xudunta ganacsiga iyo isku xirka bartamaha iyo woqooyiga Soomaaliya. Waxay caan ku tahay suuqyada xoolaha, caanaha, xarumaha suugaanta, iyo doorka ay ku leedahay dhaqanka iyo nabadda Puntland.',
                'latitude' => 6.7697,
                'longitude' => 47.4308,
                'featured_image' => 'images/cities/garowe.jpg',
                'entry_fee' => 15.00,
                'rating' => 4.80,
                'best_season' => 'All Year',
                'packages' => [
                    [
                        'title' => 'Galkacyo Trade & Nomad Culture Safari',
                        'duration_days' => 2,
                        'price_per_person' => 140.00,
                        'max_capacity' => 15,
                        'services' => ['Hotel stay', 'Suuqa xoolaha tour', 'Cultural dinner', 'Local transport']
                    ]
                ]
            ],
            [
                'title' => 'Taleex Historic Dervish Fortresses (Sool)',
                'slug' => 'taleex-dervish-fortresses',
                'region' => 'Sool',
                'city' => 'Taleex',
                'category_id' => $catFort->id,
                'description' => 'Magaalada taariikhiga ah ee Taleex waxay ahayd xaruntii weyneyd ee dawladdii Daraawiishta ee Sayid Maxamed Cabdille Xasan. Waxaa ku yaal afar qalcaddood oo waaweyn sida Silsilad, Falxa, Daawad, iyo Hed-Kaad oo ah kayd taariikheed oo aan duugoobin.',
                'latitude' => 9.1469,
                'longitude' => 48.4214,
                'featured_image' => 'images/destinations/eyl_castle.jpg',
                'entry_fee' => 25.00,
                'rating' => 4.95,
                'best_season' => 'October - March',
                'packages' => [
                    [
                        'title' => 'Taleex Dervish Historical Expedition',
                        'duration_days' => 3,
                        'price_per_person' => 240.00,
                        'max_capacity' => 12,
                        'services' => ['Historical Castle tour', 'Poetry guide', 'Accommodations', '4x4 Desert transport']
                    ]
                ]
            ],
            [
                'title' => 'Qardho Cultural & Royal Capital (Karkaar)',
                'slug' => 'qardho-cultural-capital',
                'region' => 'Karkaar',
                'city' => 'Qardho',
                'category_id' => $catCity->id,
                'description' => 'Magaalada Qardho waa caasimadda taariikhiga ah ee Boqortooyadii Majeerteen iyo gobolka Karkaar. Waxay caan ku tahay dhaqanka suuban, guryaha qadiimiga ah, heersareynta suugaanta, suuqyada caanaha geela, iyo dhacdooyinka dhaqameed ee Puntland.',
                'latitude' => 9.5034,
                'longitude' => 49.0858,
                'featured_image' => 'images/destinations/garowe_city.jpg',
                'entry_fee' => 15.00,
                'rating' => 4.88,
                'best_season' => 'All Year',
                'packages' => [
                    [
                        'title' => 'Qardho Royal Heritage & Camel Trek',
                        'duration_days' => 2,
                        'price_per_person' => 160.00,
                        'max_capacity' => 20,
                        'services' => ['Cultural Palace Tour', 'Somali Coffee Ceremony', 'Hotel accommodation', 'City Tour']
                    ]
                ]
            ],
            [
                'title' => 'Badhan & Sanaag Highland Valleys',
                'slug' => 'badhan-sanaag-valleys',
                'region' => 'Sanaag',
                'city' => 'Badhan',
                'category_id' => $catMountain->id,
                'description' => 'Magaalada Badhan (Baran) waxay ku taallaa bariga gobolka Sanaag iyadoo ku teedsan dooxooyinka iyo buuraha quruxda badan. Waa xarun ganacsi iyo waxbarasho oo leh cimilo macaan iyo deegaan buuraley ah oo cagaaran.',
                'latitude' => 10.7139,
                'longitude' => 48.3372,
                'featured_image' => 'images/destinations/cal_madow.jpg',
                'entry_fee' => 20.00,
                'rating' => 4.82,
                'best_season' => 'September - April',
                'packages' => [
                    [
                        'title' => 'Badhan Highland Mountain Trail',
                        'duration_days' => 3,
                        'price_per_person' => 210.00,
                        'max_capacity' => 12,
                        'services' => ['Valley Hiking', 'Local guide', 'Eco-camp', 'Meals & Transport']
                    ]
                ]
            ],
            [
                'title' => 'Las Khorey Ancient Port & Fish Market (Sanaag)',
                'slug' => 'las-khorey-ancient-port',
                'region' => 'Sanaag',
                'city' => 'Las Khorey',
                'category_id' => $catBeach->id,
                'description' => 'Magaalada xeebta qadiimiga ah ee Laasqoray waxay caan ku tahay wershadda kalluunka tuna-da, taariikhda dekadaha qadiimiga ah ee Gacanka Cadan, iyo xeebaha bacaadka cad leh ee biyaha nadiifta ah.',
                'latitude' => 11.1608,
                'longitude' => 48.1967,
                'featured_image' => 'images/destinations/qandala_coast.jpg',
                'entry_fee' => 25.00,
                'rating' => 4.90,
                'best_season' => 'October - March',
                'packages' => [
                    [
                        'title' => 'Las Khorey Coastal Fishing & Dhow Safari',
                        'duration_days' => 3,
                        'price_per_person' => 220.00,
                        'max_capacity' => 10,
                        'services' => ['Boat fishing', 'Tuna tasting tour', 'Seaside lodging', 'Local transfers']
                    ]
                ]
            ],
            [
                'title' => 'Iskushuban Waterfalls & Date Palms (Bari)',
                'slug' => 'iskushuban-waterfalls',
                'region' => 'Bari',
                'city' => 'Iskushuban',
                'category_id' => $catMountain->id,
                'description' => 'Degmada Iskushuban waxay caan ku tahay biyo-dhacyada dabiiciga ah ee xilliyada roobka, geedaha timirta ee dooxada dhex mara, qalcadihii Boqortooyada, iyo dhismayaasha dhagaxa ah ee qadiimiga ah.',
                'latitude' => 10.2833,
                'longitude' => 50.2333,
                'featured_image' => 'images/destinations/bosaso_port.jpg',
                'entry_fee' => 20.00,
                'rating' => 4.92,
                'best_season' => 'All Year',
                'packages' => [
                    [
                        'title' => 'Iskushuban Oasis & Waterfall Expedition',
                        'duration_days' => 2,
                        'price_per_person' => 170.00,
                        'max_capacity' => 15,
                        'services' => ['Waterfall hike', 'Date palm tour', 'Camp meals', 'Guide']
                    ]
                ]
            ]
        ];

        foreach ($citiesData as $item) {
            $dest = Destination::firstOrCreate(['slug' => $item['slug']], [
                'category_id' => $item['category_id'],
                'title' => $item['title'],
                'region' => $item['region'],
                'city' => $item['city'],
                'description' => $item['description'],
                'latitude' => $item['latitude'],
                'longitude' => $item['longitude'],
                'featured_image' => $item['featured_image'],
                'entry_fee' => $item['entry_fee'],
                'rating' => $item['rating'],
                'is_featured' => true,
                'best_season' => $item['best_season']
            ]);

            foreach ($item['packages'] as $pkg) {
                $pslug = Str::slug($pkg['title']);
                TourPackage::firstOrCreate(['slug' => $pslug], [
                    'destination_id' => $dest->id,
                    'title' => $pkg['title'],
                    'duration_days' => $pkg['duration_days'],
                    'price_per_person' => $pkg['price_per_person'],
                    'max_capacity' => $pkg['max_capacity'],
                    'included_services' => $pkg['services'],
                    'status' => 'active'
                ]);
            }
        }
    }
}
