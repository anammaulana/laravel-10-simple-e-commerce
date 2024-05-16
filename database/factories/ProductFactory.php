<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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
        $faker = \Faker\Factory::create();
        

        return [
            'name' => $faker->randomElement(['Product1', 'Product2', 'Product3']),
            'price' => $faker->numberBetween(10000, 50000),
            'description' => $faker->sentence,
            'category' => $faker->randomElement(['Category 1', 'Category 2', 'Category 3']),
            'image' => 'product' . $faker->numberBetween(1, 5) . '.jpg', // Contoh: product1.jpg, product2.jpg, dst.
            'stock' => $faker->numberBetween(1, 100),
        ];
    }
}
