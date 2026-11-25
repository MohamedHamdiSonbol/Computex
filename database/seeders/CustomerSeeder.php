<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Customer;
use App\Models\Governorate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = Customer::create([
            'first_name' => 'Customer',
            'last_name' => 'Client',
            'email' => 'customer@customers.com',
            'password' => bcrypt('12345678'),
        ]);

//        $govId = Governorate::first()->id ?? 1;
//        $cityId = City::where('governorate_id', $govId)->first()->id ?? 1;

        $customer->profile()->create([
            'governorate_id' => 1,
            'city_id' => 1,
            'mobile' => '01094954748',
            'address' => 'Giza - 6-October',
        ]);
    }
}
