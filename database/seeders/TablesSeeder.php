<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Seeder;

class TablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($tables = 0 ; $tables < 10; $tables++){
            $table = new Table();
            $table->capacity = $tables+1;
            $table->save();
        }
    }
}
