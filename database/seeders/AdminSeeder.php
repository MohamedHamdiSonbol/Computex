<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create the Master Admin Profile
        $admin = Admin::create([
            'name' => 'Mohamed Hamdi',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
            'role_id' => 1,
        ]);

        // 2. Setup Profile Info (Luxor setup)
        $admin->profile()->create([
            'governorate_id' => 1,
            'city_id' => 1,
            'mobile' => '01026659874',
            'address' => 'Luxor - Firouz',

        ]);

        // 3. Find the super-admin role from the database
//        $superAdminRole = Role::where('name', 'super-admin')->first();
//
//        // 4. Assign the role to this admin user in the pivot table
//        if ($superAdminRole) {
//            $admin->roles()->attach($superAdminRole->id);
//        }
///////////////////////////////////////////////////////////////////////////////////////////
        $subAdmin = Admin::create([
            'name' => 'Ahmed Morad',
            'email' => 'sub_admin@sub_admin.com',
            'password' => bcrypt('12345678'),
            'role_id' => 2,
        ]);

        // 2. Setup Profile Info (Luxor setup)
        $subAdmin->profile()->create([
            'governorate_id' => 2,
            'city_id' => 2,
            'mobile' => '01026659874',
            'address' => 'Anything - street',
        ]);

        // 3. Find the super-admin role from the database
//        $subAdminRole = Role::where('name', 'sub-admin')->first();
//
//        // 4. Assign the role to this admin user in the pivot table
//        if ($subAdminRole) {
//            $subAdmin->roles()->attach($subAdminRole->id);
//        }
///////////////////////////////////////////////////////////////////////////////////////////
        $staffSupport = Admin::create([
            'name' => 'Fady Bakry',
            'email' => 'support@support.com',
            'password' => bcrypt('12345678'),
            'role_id' => 3,
        ]);

        // 2. Setup Profile Info (Luxor setup)
        $staffSupport->profile()->create([
            'governorate_id' => 3,
            'city_id' => 3,
            'mobile' => '01026659874',
            'address' => 'Something - street',
        ]);

        // 3. Find the super-admin role from the database
//        $staffSupportRole = Role::where('name', 'staff')->first();
//
//        // 4. Assign the role to this admin user in the pivot table
//        if ($staffSupportRole) {
//            $staffSupport->roles()->attach($staffSupportRole->id);
//        }


    }
}
