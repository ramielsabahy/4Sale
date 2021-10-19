<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Seeder;

class MealsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($meals = 0 ; $meals < 10; $meals++){
            $meal = new Meal();
            $meal->description = 'Meal #'.($meals+1);
            $meal->price = rand(1,200);
            $meal->quantity_available = $meals;
            $meal->discount = $meals;
            $meal->save();
        }
    }
}
