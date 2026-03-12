<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(20)->create();

        $cities = City::factory(10)->create();

        Review::factory(50)->create()->each(function (Review $review) use ($cities) {
            if (rand(0, 1)) {
                return;
            }

            $review->cities()->attach(
                $cities->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
