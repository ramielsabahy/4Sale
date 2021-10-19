<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(CustomerSeeder::class);
         $this->call(MealsSeeder::class);
         $this->call(TablesSeeder::class);
         $this->call(WaitersSeeder::class);
    }
}
