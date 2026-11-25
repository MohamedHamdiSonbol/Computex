<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    // Can the admin view the list of products?
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view-categories');
    }

    // Can the admin view a single product profile?
    public function view(Admin $admin, Category $category): bool
    {
        return $admin->can('view-categories');
    }

    // Can the admin create a product?
    public function create(Admin $admin): bool
    {
        return $admin->can('create-categories');
    }

    // Can the admin edit a product?
    public function update(Admin $admin, Category $category): bool
    {
        return $admin->can('edit-categories');
    }

    // Can the admin delete a product?
    public function delete(Admin $admin, Category $category): bool
    {
        return $admin->can('delete-categories');
    }

    // Can the admin toggle active a product?
    public function toggleActive(Admin $admin, Category $category): bool
    {
        return $admin->can('toggleActive-categories');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Category $category): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Category $category): bool
    {
        //
    }
}
