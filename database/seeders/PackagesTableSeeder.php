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
                    'id' => 1,
                    'value' => 'Hair styling',
                    'position' => 1
                ],
                [
                    'id' => 2,
                    'value' => 'Make over',
                    'position' => 2
                ],
            ],
            'price' => 7000.00,
            'hours' => 1,
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
                    'id' => 1,
                    'value' => 'Hair styling',
                    'position' => 1
                ],
                [
                    'id' => 2,
                    'value' => 'Ornaments setting',
                    'brand' => 'Colors Queen',
                    'position' => 2
                ],
                [
                    'id' => 3,
                    'value' => 'Costume settings',
                    'brand' => 'Loreal',
                    'position' => 3
                ],
                [
                    'id' => 4,
                    'value' => 'Make over',
                    'position' => 4
                ],
            ],
            'price' => 7000.00,
            'hours' => 1,
            'booking_price' => 10.00,
            'booking_price_type' => 'percentage',
            'special_price' => 0,
            'special_price_type' => 'fixed',
            'special_price_start' => null,
            'special_price_end' => null,
            'status' => 1
        ]);
        
        $bianla = Package::create([
            'name' => 'Bianla',
            'slug' => Str::slug('Bianla'),
            'description' => '<p>The basic package</p>',
            'features' => [
                [
                    'id' => 1,
                    'value' => 'Hair styling',
                    'position' => 1
                ],
                [
                    'id' => 2,
                    'value' => 'Ornaments setting',
                    'brand' => 'Huda Beauty',
                    'position' => 2
                ],
                [
                    'id' => 3,
                    'value' => 'Costume settings',
                    'brand' => 'For ever',
                    'position' => 3
                ],
                [
                    'id' => 4,
                    'value' => 'Make over',
                    'position' => 4
                ],
            ],
            'price' => 7000.00,
            'hours' => 1,
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
