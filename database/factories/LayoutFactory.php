<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;
use App\Models\Component;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Layout>
 */
class LayoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_component' => fake()->randomElement(Component::pluck('name')),
            'second_component' => fake()->randomElement(Component::pluck('name')),
            'third_component' => fake()->randomElement(Component::pluck('name')),
            'company_id' => fake()->randomElement(Company::pluck('id')),
        ];
    }
}
