<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;
use App\Models\TourPackage;
use App\Models\Category;
use Illuminate\Support\Str;

class CityPackagesSeeder extends Seeder
{
    /**
     * Seed realistic and complete destinations for Puntland without duplication.
     */
    public function run(): void
    {
        // 1. Ensure standard categories exist
        $catBeach = Category::firstOrCreate(['slug' => 'coastal-beaches'], [
            'name' => 'Coastal & Beaches',
            'icon' => 'fa-umbrella-beach',
            'description' => 'Turquoise ocean water, white sand beaches, marine safari, and coastal ports.'
        ]);

        $catFort = Category::firstOrCreate(['slug' => 'historical-forts'], [
            'name' => 'Historical Forts & Castles',
            'icon' => 'fa-fort-awesome',
            'description' => 'Centuries-old stone fortresses, Dervish castles, and ancient frankincense trading ports.'
        ]);

        $catMountain = Category::firstOrCreate(['slug' => 'mountain-ranges'], [
            'name' => 'Mountain Ranges & Valleys',
            'icon' => 'fa-mountain',
            'description' => 'Cool mountain elevations, natural waterfalls, frankincense forests, and hiking canyons.'
        ]);

        $catCity = Category::firstOrCreate(['slug' => 'modern-cities'], [
            'name' => 'Modern Cities & Cultural Heritage',
            'icon' => 'fa-city',
            'description' => 'Vibrant urban centers, traditional markets, state monuments, and Somali cuisine.'
        ]);

        // 2. Define the comprehensive 13 locations precisely as requested
        $citiesData = [
            // 1. Garowe
            [
                'city' => 'Garowe', 'region' => 'Nugaal', 'category_id' => $catCity->id,
                'lat' => 8.4064, 'lon' => 48.4844,
                'dests' => [
                    [
                        'title' => 'Garowe Capital City Center',
                        'desc' => 'Caasimadda dawlad goboleedka Puntland, xarunta nabadda, dawladnimada iyo maamulka. Waxay caan ku tahay bilicda, suuqyada dhaqanka iyo cuntooyinka asalka ah.',
                        'entry_fee' => 15.00, 'rating' => 4.90, 'best_season' => 'All Year',
                        'pkgs' => [
                            ['title' => 'Garowe City Tour', 'days' => 2, 'price' => 120.00, 'max' => 20, 'svcs' => ['Hotel', 'Transport', 'City Guide', 'Lunch']]
                        ]
                    ]
                ]
            ],
            // 2. Raas_casyr
            [
                'city' => 'Raas_casyr', 'region' => 'Gardafuul', 'category_id' => $catBeach->id,
                'lat' => 11.8333, 'lon' => 51.2667,
                'dests' => [
                    [
                        'title' => 'Raas_casyr & Gacanka Badda',
                        'desc' => 'Halka ugu bariisan qaaradda Afrika, halkaas oo ay isaga darsamaan labada badood ee Badda Cas iyo Badweynta Hindiya. Waa goob taariikhi ah oo dalxiis u roon.',
                        'entry_fee' => 30.00, 'rating' => 4.98, 'best_season' => 'November - March',
                        'pkgs' => [
                            ['title' => 'Raas_casyr Expedition', 'days' => 4, 'price' => 450.00, 'max' => 10, 'svcs' => ['Camping', '4x4 Transport', 'Boat ride', 'Meals']]
                        ]
                    ]
                ]
            ],
            // 3. Ceerigaabo
            [
                'city' => 'Ceerigaabo', 'region' => 'Sanaag', 'category_id' => $catMountain->id,
                'lat' => 10.6190, 'lon' => 47.3680,
                'dests' => [
                    [
                        'title' => 'Ceerigaabo iyo Buuraha Daallo',
                        'desc' => 'Caasimadda buuraleyda ee gobolka Sanaag, waxay caan ku tahay cimilo aad u qabow, dhirta baxa xilliga roobabka, cagaarka iyo keymaha waawayn ee Daallo.',
                        'entry_fee' => 20.00, 'rating' => 4.93, 'best_season' => 'September - May',
                        'pkgs' => [
                            ['title' => 'Ceerigaabo Nature Trail', 'days' => 3, 'price' => 280.00, 'max' => 15, 'svcs' => ['Lodge', 'Tour Guide', 'Hiking', 'Breakfast']]
                        ]
                    ]
                ]
            ],
            // 4. Calmadow
            [
                'city' => 'Calmadow', 'region' => 'Sanaag', 'category_id' => $catMountain->id,
                'lat' => 10.7431, 'lon' => 47.2412,
                'dests' => [
                    [
                        'title' => 'Buuraha Calmadow iyo Biyo Dhaca',
                        'desc' => 'Buuraha ugu dhaadheer uguna quruxda badan Soomaaliya, halkaas oo aad ugu riyaaqi karto biyo dhac (waterfalls) cajiib ah, cagaar, iyo shimbiro kala duwan.',
                        'entry_fee' => 40.00, 'rating' => 4.99, 'best_season' => 'All Year',
                        'pkgs' => [
                            ['title' => 'Calmadow Hiking Adventure', 'days' => 5, 'price' => 550.00, 'max' => 8, 'svcs' => ['Tent Camping', 'Guide', 'Trekking gear', 'All meals']]
                        ]
                    ]
                ]
            ],
            // 5. Laas_qoray
            [
                'city' => 'Laas_qoray', 'region' => 'Sanaag', 'category_id' => $catBeach->id,
                'lat' => 11.1600, 'lon' => 48.1970,
                'dests' => [
                    [
                        'title' => 'Xeebta Taariikhiga ah ee Laas_qoray',
                        'desc' => 'Magaalo xeebeed caan ku ah taariikh fog iyo kalluumaysiga. Waxay xuddun u ahayd ganacsiga badda oo hodan ku ah kheyraadka kalluunka tuunaha.',
                        'entry_fee' => 15.00, 'rating' => 4.88, 'best_season' => 'October - April',
                        'pkgs' => [
                            ['title' => 'Laas_qoray Fishery & Beach Tour', 'days' => 3, 'price' => 210.00, 'max' => 12, 'svcs' => ['Guesthouse', 'Fishing Trip', 'Seafood BBQ', 'Transport']]
                        ]
                    ]
                ]
            ],
            // 6. Qandala
            [
                'city' => 'Qandala', 'region' => 'Bari', 'category_id' => $catFort->id,
                'lat' => 11.4719, 'lon' => 49.8728,
                'dests' => [
                    [
                        'title' => 'Qandala, Qalcaddaha iyo Beeyada',
                        'desc' => 'Dhul isku dara badda cagaaran, buuraha, iyo taariikhda. Qandala waxay caan ku tahay dhismayaasha dhagaxa ah, doonyaha la sameeyo iyo buuraha laga guro luubaanta iyo beeyada.',
                        'entry_fee' => 25.00, 'rating' => 4.95, 'best_season' => 'All Year',
                        'pkgs' => [
                            ['title' => 'Qandala Heritage Trip', 'days' => 3, 'price' => 320.00, 'max' => 12, 'svcs' => ['Hotel', 'Frankincense Tour', 'Boat Ride', 'Meals']]
                        ]
                    ]
                ]
            ],
            // 7. Boosaaso
            [
                'city' => 'Boosaaso', 'region' => 'Bari', 'category_id' => $catBeach->id,
                'lat' => 11.2842, 'lon' => 49.1816,
                'dests' => [
                    [
                        'title' => 'Boosaaso Commercial Hub & Beach',
                        'desc' => 'Isha dhaqaalaha Puntland oo idil. Magaalo deked leh oo leh suuqyo waawayn, xeebo qurxoon, iyo goobo muhiim u ah dalxiiska.',
                        'entry_fee' => 20.00, 'rating' => 4.92, 'best_season' => 'October - March',
                        'pkgs' => [
                            ['title' => 'Boosaaso Weekend Getaway', 'days' => 2, 'price' => 180.00, 'max' => 25, 'svcs' => ['Resort', 'Transport', 'City Tour', 'Dinner']]
                        ]
                    ]
                ]
            ],
            // 8. Eyl
            [
                'city' => 'Eyl', 'region' => 'Nugaal', 'category_id' => $catFort->id,
                'lat' => 7.9803, 'lon' => 49.8164,
                'dests' => [
                    [
                        'title' => 'Eyl Daawad & Qalcadda Taariikhiga',
                        'desc' => 'Qalcado taariikhi ah oo xasuus leh xilligii Daraawiishta. Eyl sidoo kale waxay leedahay dooxyo iyo xeeb cajiib ah oo lagu dalxiiso.',
                        'entry_fee' => 25.00, 'rating' => 4.96, 'best_season' => 'All Year',
                        'pkgs' => [
                            ['title' => 'Eyl Historic Safari', 'days' => 3, 'price' => 300.00, 'max' => 15, 'svcs' => ['Lodge', 'Fort Guide', 'Beach access', 'Meals']]
                        ]
                    ]
                ]
            ],
            // 9. Gaalkacyo
            [
                'city' => 'Gaalkacyo', 'region' => 'Mudug', 'category_id' => $catCity->id,
                'lat' => 6.7697, 'lon' => 47.4308,
                'dests' => [
                    [
                        'title' => 'Gaalkacyo Xuddunta Mudug',
                        'desc' => 'Magaalo u dhaxaysa gobolada waqooyi iyo koonfur, caan ku ah suuqyada xoolaha, ganacsiga isku-gudbinta iyo hiddaha dhaqanka miyiga.',
                        'entry_fee' => 10.00, 'rating' => 4.82, 'best_season' => 'All Year',
                        'pkgs' => [
                            ['title' => 'Mudug Nomadic Experience', 'days' => 2, 'price' => 140.00, 'max' => 20, 'svcs' => ['Hotel', 'Transport', 'Market Tour', 'Lunch']]
                        ]
                    ]
                ]
            ],
            // 10. Qardho
            [
                'city' => 'Qardho', 'region' => 'Karkaar', 'category_id' => $catCity->id,
                'lat' => 9.5042, 'lon' => 49.0833,
                'dests' => [
                    [
                        'title' => 'Qardho Xarunta Dhaqanka',
                        'desc' => 'Fadhiga boqortooyada iyo dhaqanka faca-weyn. Waxay caan ku tahay geedaha timirta, xoolaha iyo cimilo macaan.',
                        'entry_fee' => 10.00, 'rating' => 4.85, 'best_season' => 'All Year',
                        'pkgs' => [
                            ['title' => 'Qardho Royal Heritage', 'days' => 2, 'price' => 150.00, 'max' => 15, 'svcs' => ['Hotel', 'Cultural Tour', 'Meals']]
                        ]
                    ]
                ]
            ],
            // 11. Taleex
            [
                'city' => 'Taleex', 'region' => 'Sool', 'category_id' => $catFort->id,
                'lat' => 9.1450, 'lon' => 48.4210,
                'dests' => [
                    [
                        'title' => 'Qalcadda Taleex (Silsilad)',
                        'desc' => 'Qalcadda ugu wayn ee taariikhiga ah taas oo fariisin u ahayd halgankii Daraawiishta. Waa mid ka mid ah astaamaha ugu waaweyn ee halganka Soomaaliyeed.',
                        'entry_fee' => 20.00, 'rating' => 4.97, 'best_season' => 'October - April',
                        'pkgs' => [
                            ['title' => 'Taleex Dervish History Tour', 'days' => 3, 'price' => 260.00, 'max' => 10, 'svcs' => ['Guesthouse', 'History Guide', 'Transport', 'Meals']]
                        ]
                    ]
                ]
            ],
            // 12. Badhan
            [
                'city' => 'Badhan', 'region' => 'Sanaag', 'category_id' => $catMountain->id,
                'lat' => 10.7130, 'lon' => 48.3370,
                'dests' => [
                    [
                        'title' => 'Badhaniyo Togagga Biyaha',
                        'desc' => 'Magaalo si xawli ah ku koreysa oo ku dhax taal dooxooyin cagaaran, biyo joogto ah, iyo beero wax soo saar badan leh.',
                        'entry_fee' => 15.00, 'rating' => 4.80, 'best_season' => 'All Year',
                        'pkgs' => [
                            ['title' => 'Badhan Valley Tour', 'days' => 2, 'price' => 170.00, 'max' => 12, 'svcs' => ['Hotel', 'Valley Tour', 'Transport', 'Meals']]
                        ]
                    ]
                ]
            ],
            // 13. Galdogob
            [
                'city' => 'Galdogob', 'region' => 'Mudug', 'category_id' => $catCity->id,
                'lat' => 7.0225, 'lon' => 46.9950,
                'dests' => [
                    [
                        'title' => 'Galdogob iyo Daqaanka',
                        'desc' => 'Magaalo si degdeg ah u koreysa oo ku taal xudduudka, caan ku ah ganacsiga xoolaha, iyo nabadgalyo. Waxay leedahay muuqaalo degan iyo dhaqan aslan.',
                        'entry_fee' => 10.00, 'rating' => 4.75, 'best_season' => 'All Year',
                        'pkgs' => [
                            ['title' => 'Galdogob Community Visit', 'days' => 2, 'price' => 130.00, 'max' => 15, 'svcs' => ['Hotel', 'City guide', 'Meals', 'Transport']]
                        ]
                    ]
                ]
            ]
        ];

        foreach ($citiesData as $cityItem) {
            foreach ($cityItem['dests'] as $dItem) {
                // Determine valid image filename based on the new slug naming convention
                $imgName = Str::slug($cityItem['city']);
                
                $slug = Str::slug($dItem['title']);
                $dest = Destination::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'category_id'    => $cityItem['category_id'],
                        'title'          => $dItem['title'],
                        'region'         => $cityItem['region'],
                        'city'           => $cityItem['city'],
                        'description'    => $dItem['desc'],
                        'latitude'       => $cityItem['lat'],
                        'longitude'      => $cityItem['lon'],
                        'featured_image' => 'images/cities/' . $imgName . '.jpg',
                        'entry_fee'      => $dItem['entry_fee'],
                        'rating'         => $dItem['rating'],
                        'is_featured'    => true,
                        'best_season'    => $dItem['best_season'],
                    ]
                );

                foreach ($dItem['pkgs'] as $pItem) {
                    $pSlug = Str::slug($pItem['title']);
                    TourPackage::updateOrCreate(
                        ['slug' => $pSlug],
                        [
                            'destination_id'    => $dest->id,
                            'title'             => $pItem['title'],
                            'duration_days'     => $pItem['days'],
                            'price_per_person'  => $pItem['price'],
                            'max_capacity'      => $pItem['max'],
                            'included_services' => $pItem['svcs'],
                            'start_date'        => now()->addDays(5)->toDateString(),
                            'status'            => 'active',
                        ]
                    );
                }
            }
        }

        $this->command->info('Successfully seeded realistic destinations and packages for all 13 targeted Puntland cities!');
    }
}


