<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Review;
use App\Models\Advertisement;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'review' => fake()->realText(300),
            'published_at' => now(),
            'user_id' => fake()->randomElement(User::pluck('id')),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Review $review) {

            if(rand(0,1) == 1) 
            {
                $advertisement = Advertisement::inRandomOrder()->first();
                $advertisement->reviews()->attach($review->id);
            }
            else 
            {
                $user = User::inRandomOrder()->first();
                $user->reviews()->attach($review->id);
            }
        });
    }
}
