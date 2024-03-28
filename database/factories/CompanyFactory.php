<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Company;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company,
            'slug' => fake()->slug,
            'logo' => null,
            'introduction_text' => fake()->realText(400),
            'font_style' => null,
            'primary_color' => fake()->hexcolor,
            'secondary_color' => fake()->hexcolor,
            'user_id' => fake()->randomElement(User::pluck('id')),
        ];
    }

    public function configure()
    {
        //TODO: change factory for duplicating users for different companies

        return $this->afterCreating(function (Company $company) {
            $user = User::findOrFail($company->user_id);
            $user->syncRoles('zakelijke adverteerder');
            $user->givePermissionTo(['contract accepted']);
        });
    }
}
