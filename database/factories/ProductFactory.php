<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'slug' => Str::slug($this->faker->name()),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'category_id' => rand(1, 3),
        ];
    }
}
