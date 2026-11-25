<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    // Can the admin view the list of products?
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view-admins');
    }

    // Can the admin view a single product profile?
    public function view(Admin $admin): bool
    {
        return $admin->can('view-admins');
    }

    // Can the admin create a product?
    public function create(Admin $admin): bool
    {
        return $admin->can('create-admins');
    }

    // Can the admin edit a product?
    public function update(Admin $admin): bool
    {
        return $admin->can('edit-admins');
    }

    // Can the admin delete a product?
    public function delete(Admin $admin): bool
    {
        return $admin->can('delete-admins');
    }

    // Can the admin toggle active a product?
    public function toggleActive(Admin $admin): bool
    {
        return $admin->can('toggleActive-admins');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin): bool
    {
        //
    }
}
