<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($customers = 0 ; $customers < 10; $customers++){
            $customer = new Customer();
            $customer->name = '4Sale User '.($customers+1);
            $customer->phone = '0101010101'.$customers;
            $customer->save();
        }
    }
}
