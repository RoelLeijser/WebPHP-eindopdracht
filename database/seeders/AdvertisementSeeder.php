<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Advertisement;
use App\Models\Bid;

class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ads = Advertisement::factory(25)->create();
        $ads->where('type', 'auction')->each(function ($ad) {
            Bid::factory(5)->create([
                'advertisement_id' => $ad->id,
            ]);
        });
    }
}
