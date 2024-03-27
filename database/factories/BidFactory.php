<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Advertisement;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bid>
 */
class BidFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $advertisement = Advertisement::where('type', 'auction')->with('bids')->inRandomOrder()->first();

        $currentHighestBid = $advertisement->bids->max('amount') ?? $advertisement->price;

        $amount = fake()->randomFloat(2, $currentHighestBid, $currentHighestBid + 100);

        return [
            'advertisement_id' => $advertisement->id,
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'amount' => $amount,
        ];
    }
}
