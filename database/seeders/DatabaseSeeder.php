<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Layout;
use App\Models\Review;


class DatabaseSeeder extends Seeder
{
        /**
         * Seed the application's database.
         */
        public function run(): void
        {
                $this->call(PermissionRoleSeeder::class);
                User::factory(10)->create();
                $this->call(AdvertisementSeeder::class);
                $this->call(ComponentSeeder::class);
                Company::factory(5)->create();
                Layout::factory(5)->create();
                Review::factory(10)->create();
        }
}
