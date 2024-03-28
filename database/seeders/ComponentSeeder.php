<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Component;

class ComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Component::create(['name' => 'introduction']);
        Component::create(['name' => 'adverts']);
        Component::create(['name' => 'reviews']);
    }
}
