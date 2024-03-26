<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Advertisement;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advertisement>
 */
class AdvertisementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 0, 1000),
            'image' => fake()->imageUrl(),
            'type' => fake()->randomElement(['auction', 'rental']),
            'seller_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'delivery' => fake()->randomElement(['pickup', 'shipping', 'pickup_shipping']),
        ];
    }
}
