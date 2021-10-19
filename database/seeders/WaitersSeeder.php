<?php

namespace Database\Seeders;

use App\Models\Table;
use App\Models\Waiter;
use Illuminate\Database\Seeder;

class WaitersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($waiters = 0 ; $waiters < 10; $waiters++){
            $waiter = new Waiter();
            $waiter->name = '4Sale Waiter #'.($waiters);
            $waiter->save();
        }
    }
}
