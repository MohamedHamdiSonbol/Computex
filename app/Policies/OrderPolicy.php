<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    // Can the admin view the list of products?
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view-orders');
    }

    // Can the admin view a single product profile?
    public function view(Admin $admin, Order $order): bool
    {
        return $admin->can('view-orders');
    }

    // Can the admin create a product?
    public function create(Admin $admin): bool
    {
        return $admin->can('create-orders');
    }

    // Can the admin edit a product?
    public function update(Admin $admin, Order $order): bool
    {
        return $admin->can('edit-orders');
    }

    // Can the admin delete a product?
    public function delete(Admin $admin, Order $order): bool
    {
        return $admin->can('delete-orders');
    }

    // Can the admin toggle active a product?
    public function toggleActive(Admin $admin, Order $order): bool
    {
        return $admin->can('toggleActive-orders');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Order $order): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Order $order): bool
    {
        //
    }
}
