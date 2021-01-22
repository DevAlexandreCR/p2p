<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => $this->faker->firstName,
            'reference' => $this->faker->numerify('#####'),
            'description' => $this->faker->sentence(),
            'stock' => $this->faker->numberBetween(1,5),
            'price' => $this->faker->numberBetween(10000, 500000),
            'image' => 'default.png',
        ];
    }
}
