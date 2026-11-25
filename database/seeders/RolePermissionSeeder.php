<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Define Default Core Roles
        $superAdminRole = Role::create(['name' => 'super-admin', 'display_name' => 'Super Admin']);
        $subAdminRole   = Role::create(['name' => 'sub-admin', 'display_name' => 'Sub Admin']);
        $staffRole      = Role::create(['name' => 'staff', 'display_name' => 'Staff / Support']);

        // 2. Define Granular E-commerce Permissions
        $permissions = [
            // Product Permissions
            ['name' => 'view-products', 'display_name' => 'View Products'],
            ['name' => 'create-products', 'display_name' => 'Create Products'],
            ['name' => 'edit-products', 'display_name' => 'Edit Products'],
            ['name' => 'delete-products', 'display_name' => 'Delete Products'],

            // Order Permissions
            ['name' => 'view-orders', 'display_name' => 'View Orders'],
            ['name' => 'update-orders', 'display_name' => 'Update Order Status'],

            // Staff/Authorization Management Permissions
            ['name' => 'manage-staff', 'display_name' => 'Manage Staff & Roles'],
        ];

        // 3. Insert Permissions into Database & Collect them
        $permissionInstances = [];
        foreach ($permissions as $perm) {
            $permissionInstances[$perm['name']] = Permission::create($perm);
        }

        // 4. Assign Permissions to Roles Dynamically

        // Sub-Admin gets everything EXCEPT deleting products or managing other staff members
        $subAdminRole->permissions()->sync([
            $permissionInstances['view-products']->id,
            $permissionInstances['create-products']->id,
            $permissionInstances['edit-products']->id,
            $permissionInstances['view-orders']->id,
            $permissionInstances['update-orders']->id,
        ]);

        // Regular Staff can only view products and manage order fulfillment
        $staffRole->permissions()->sync([
            $permissionInstances['view-products']->id,
            $permissionInstances['view-orders']->id,
            $permissionInstances['update-orders']->id,
        ]);

        // Note: 'super-admin' doesn't explicitly need permissions synced in the database
        // because our AppServiceProvider Gate::before bypass rule grants them everything automatically!
    }
}
