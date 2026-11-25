<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Super Visor',
            'email' => 'user@user.com',
            'password' => bcrypt('12345678'),
        ]);

        $user->profile()->create([
            'governorate_id' => 1,
            'city_id' => 1,
            'mobile' => '01254579912',
            'address' => 'Aswan - Dam',
        ]);
    }
}
