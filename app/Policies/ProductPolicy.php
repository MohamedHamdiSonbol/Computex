<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    // Can the admin view the list of products?
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view-products');
    }

    // Can the admin view a single product profile?
    public function view(Admin $admin, Product $product): bool
    {
        return $admin->can('view-products');
    }

    // Can the admin create a product?
    public function create(Admin $admin): bool
    {
        return $admin->can('create-products');
    }

    // Can the admin edit a product?
    public function update(Admin $admin, Product $product): bool
    {
        return $admin->can('edit-products');
    }

    // Can the admin delete a product?
    public function delete(Admin $admin, Product $product): bool
    {
        return $admin->can('delete-products');
    }

    // Can the admin toggle active a product?
    public function toggleActive(Admin $admin, Product $product): bool
    {
        return $admin->can('toggleActive-products');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Product $product): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Product $product): bool
    {
        //
    }
}
