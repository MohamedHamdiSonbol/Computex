<?php

namespace App\Policies;

use App\Models\Coupon;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class CouponPolicy
{
    // Can the admin view the list of products?
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view-coupons');
    }

    // Can the admin view a single product profile?
    public function view(Admin $admin, Coupon $coupon): bool
    {
        return $admin->can('view-coupons');
    }

    // Can the admin create a product?
    public function create(Admin $admin): bool
    {
        return $admin->can('create-coupons');
    }

    // Can the admin edit a product?
    public function update(Admin $admin, Coupon $coupon): bool
    {
        return $admin->can('edit-coupons');
    }

    // Can the admin delete a product?
    public function delete(Admin $admin, Coupon $coupon): bool
    {
        return $admin->can('delete-coupons');
    }

    // Can the admin toggle active a product?
    public function toggleActive(Admin $admin, Coupon $coupon): bool
    {
        return $admin->can('toggleActive-coupons');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Coupon $coupon): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Coupon $coupon): bool
    {
        //
    }
}
