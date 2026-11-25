<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use Bootstrap for pagination
        Paginator::defaultView('vendor.pagination.bootstrap-5');



        // Make morph_type column to have the class name not the full path, EX:- 'admin' not 'App\Models\Admin'
        Relation::enforceMorphMap([
            // profileable morph (profile)
            'admin'      => 'App\Models\Admin',
//            'supervisor' => 'App\Models\User',
            'customer'   => 'App\Models\Customer',
            // campaignable morph (campaign)
            'brand'      => 'App\Models\Brand',
            'category'   => 'App\Models\Category',
            'product'    => 'App\Models\Product',
            // discountable morph (discount)
            'campaign'   => 'App\Models\Campaign',
            'coupon'     => 'App\Models\Coupon',
        ]);



        // 1. The Super Admin Bypass Rule
        // If an admin has ID 1 or the 'super-admin' role, grant ALL permissions automatically
        Gate::before(function ($admin, $ability) {
            if ($admin instanceof Admin && ($admin->id === 1 || $admin->hasRole('super-admin'))) {
                return true;
            }
            return null;
        });

        // 2. Dynamically Register Permissions from Database as Gates
        // Check schema first to avoid errors during initial migrations
        if (Schema::hasTable('permissions')) {
            // Eager load the roles to optimize performance
            $permissions = Permission::with('roles')->get();

            foreach ($permissions as $permission) {
                Gate::define($permission->name, function ($admin) use ($permission) {
                    // Check if the logged-in user is an Admin and has this permission
                    return $admin instanceof Admin && $admin->hasPermission($permission->name);
                });
            }
        }






    }
}
