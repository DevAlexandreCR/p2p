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
    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->firstName,
            'reference' => $this->faker->numerify('#####'),
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(),
            'stock' => $this->faker->numberBetween(1,5),
            'price' => $this->faker->numberBetween(10000, 500000),
            'image' => 'default.png',
        ];
    }
}
