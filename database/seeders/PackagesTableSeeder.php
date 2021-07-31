<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $valantine = Package::create([
            'name' => 'Valantine',
            'slug' => Str::slug('Valantine'),
            'description' => '<p>The basic package</p>',
            'features' => [
                [
                    'value' => 'Hair styling',
                    'position' => 1
                ],
                [
                    'value' => 'Make over',
                    'position' => 2
                ],
            ],
            'price' => 7000.00,
            'hours' => 3,
            'booking_price' => 10.00,
            'booking_price_type' => 'percentage',
            'special_price' => 0,
            'special_price_type' => 'fixed',
            'special_price_start' => null,
            'special_price_end' => null,
            'status' => 1
        ]);
        
        $andria = Package::create([
            'name' => 'Andria',
            'slug' => Str::slug('Andria'),
            'description' => '<p>The basic package</p>',
            'features' => [
                [
                    'value' => 'Hair styling',
                    'position' => 1
                ],
                [
                    'value' => 'Ornaments setting',
                    'position' => 2
                ],
                [
                    'value' => 'Costume settings',
                    'position' => 3
                ],
                [
                    'value' => 'Make over',
                    'position' => 4,
                    'brand' => [
                        'Colors Queen',
                        'Loreal'
                    ]
                ],
            ],
            'price' => 10000.00,
            'hours' => 3,
            'booking_price' => 10.00,
            'booking_price_type' => 'percentage',
            'special_price' => 0,
            'special_price_type' => 'fixed',
            'special_price_start' => null,
            'special_price_end' => null,
            'status' => 1
        ]);
        
        $bianca = Package::create([
            'name' => 'Bianca',
            'slug' => Str::slug('Bianca'),
            'description' => '<p>The basic package</p>',
            'features' => [
                [
                    'value' => 'Hair styling',
                    'position' => 1
                ],
                [
                    'value' => 'Ornaments setting',
                    'position' => 2
                ],
                [
                    'value' => 'Costume settings',
                    'position' => 3
                ],
                [
                    'value' => 'Make over',
                    'position' => 4,
                    'brand' => [
                        'Huda Beauty',
                        'Forever',
                        'Loreal'
                    ]
                ],
            ],
            'price' => 12000.00,
            'hours' => 3,
            'booking_price' => 10.00,
            'booking_price_type' => 'percentage',
            'special_price' => 0,
            'special_price_type' => 'fixed',
            'special_price_start' => null,
            'special_price_end' => null,
            'status' => 1
        ]);
        
        $cindrella = Package::create([
            'name' => 'Cindrella',
            'slug' => Str::slug('Cindrella'),
            'description' => '<p>The basic package</p>',
            'features' => [
                [
                    'value' => 'Hair styling',
                    'position' => 1
                ],
                [
                    'value' => 'Ornaments setting',
                    'position' => 2
                ],
                [
                    'value' => 'Costume settings',
                    'position' => 3
                ],
                [
                    'value' => 'Make over',
                    'position' => 4,
                    'brand' => [
                        'MAC',
                        'Huda Beauty',
                        'Forever',
                    ]
                ],
                [
                    'value' => 'Threading',
                    'position' => 5,
                ],
                [
                    'value' => 'Bleaching OXY',
                    'position' => 6,
                    'brand' => [
                        'Sara OXY',
                        'Shahanas'
                    ]
                ],
                [
                    'value' => 'Facial',
                    'position' => 7,
                    'brand' => [
                        'Sara OXY',
                        'Shahanas'
                    ]
                ],
            ],
            'price' => 15000.00,
            'hours' => 3,
            'booking_price' => 10.00,
            'booking_price_type' => 'percentage',
            'special_price' => 0,
            'special_price_type' => 'fixed',
            'special_price_start' => null,
            'special_price_end' => null,
            'status' => 1
        ]);
        
        $katharine = Package::create([
            'name' => 'Katharine',
            'slug' => Str::slug('Katharine'),
            'description' => '<p>The basic package</p>',
            'features' => [
                [
                    'value' => 'Hair styling',
                    'position' => 1
                ],
                [
                    'value' => 'Ornaments setting',
                    'position' => 2
                ],
                [
                    'value' => 'Costume settings',
                    'position' => 3
                ],
                [
                    'value' => 'Make over',
                    'position' => 4,
                    'brand' => [
                        'MAC',
                        'Smash Box',
                        'Huda Beauty',
                        'PAC',
                    ]
                ],
                [
                    'value' => 'Threading',
                    'position' => 5,
                ],
                [
                    'value' => 'Bleach Diamond',
                    'position' => 6,
                    'brand' => [
                        'Shahanas',
                        'Casmara',
                    ]
                ],
                [
                    'value' => 'Facial Diamond',
                    'position' => 7,
                    'brand' => [
                        'Shahanas',
                        'Casmara',
                    ]
                ],
                [
                    'value' => 'Manicure',
                    'position' => 8,
                ],
                [
                    'value' => 'Pedicure',
                    'position' => 9,
                ],
            ],
            'price' => 20000.00,
            'hours' => 3,
            'booking_price' => 10.00,
            'booking_price_type' => 'percentage',
            'special_price' => 0,
            'special_price_type' => 'fixed',
            'special_price_start' => null,
            'special_price_end' => null,
            'status' => 1
        ]);
        
        $laforma_bride = Package::create([
            'name' => 'La\'forma Bride',
            'slug' => Str::slug('La\'forma Bride'),
            'description' => '<p>The premium package</p>',
            'features' => [
                [
                    'value' => 'Hair styling',
                    'position' => 1
                ],
                [
                    'value' => 'Ornaments setting',
                    'position' => 2
                ],
                [
                    'value' => 'Costume settings',
                    'position' => 3
                ],
                [
                    'value' => 'Make over',
                    'position' => 4,
                    'brand' => [
                        'MAC',
                        'Smash Box',
                        'Huda Beauty',
                        'PAC',
                    ]
                ],
                [
                    'value' => 'Mehandi Design',
                    'position' => 5,
                ],
                [
                    'value' => 'Threading',
                    'position' => 5,
                ],
                [
                    'value' => 'Bleach PEARL',
                    'position' => 6,
                    'brand' => [
                        'Shahanas Pearl',
                        'Casmara',
                    ]
                ],
                [
                    'value' => 'Facial PEARL',
                    'position' => 7,
                    'brand' => [
                        'Shahanas Pearl',
                        'Casmara',
                    ]
                ],
                [
                    'value' => 'Manicure',
                    'position' => 8,
                ],
                [
                    'value' => 'Pedicure',
                    'position' => 9,
                ],
                [
                    'value' => 'RICCA Half hand',
                    'position' => 10,
                ],
                [
                    'value' => 'RICCA Half leg',
                    'position' => 11,
                ],
                [
                    'value' => 'D.Tan',
                    'position' => 11,
                ],
            ],
            'price' => 25000.00,
            'hours' => 3,
            'booking_price' => 10.00,
            'booking_price_type' => 'percentage',
            'special_price' => 0,
            'special_price_type' => 'fixed',
            'special_price_start' => null,
            'special_price_end' => null,
            'status' => 1
        ]);
    }
}
