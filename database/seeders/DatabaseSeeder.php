<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Layout;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionRoleSeeder::class);
        $this->call(ComponentSeeder::class);
        User::factory(15)->create();
        Company::factory(5)->create();
        Layout::factory(5)->create();
    }
}
