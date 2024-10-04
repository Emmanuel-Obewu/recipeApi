<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_US');


        for ($i = 0; $i < 50; $i++) {
            Recipe::create([
                'title' => $faker->sentence(3),
                'ingredients' => $faker->paragraph(3),
                'instructions' => $faker->paragraph(2),
                'prep_time' => $faker->numberBetween(10, 120), // time in minutes
                'difficulty' => $faker->randomElement(['Easy', 'Medium', 'Hard']),
                'user_id' => 1, // Assuming 1 for a test user, adjust as needed
            ]);
        }
    }
}
