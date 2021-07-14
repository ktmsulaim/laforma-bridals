<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Ornaments',
            'slug' => str_slug('Ornaments'),
            'show_in_nav' => 1,
            'is_orderable' => 1,
            'status' => 1,
        ]);
        
        Category::create([
            'name' => 'Garments',
            'slug' => str_slug('Garments'),
            'show_in_nav' => 1,
            'is_orderable' => 1,
            'status' => 1,
        ]);
        
        Category::create([
            'name' => 'Jewells',
            'slug' => str_slug('Jewells'),
            'show_in_nav' => 1,
            'is_orderable' => 0,
            'status' => 1,
        ]);
    }
}
