<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    // Can the admin view the list of roles?
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view-roles');
    }

    // Can the admin view a single product profile?
    public function view(Admin $admin, Role $role): bool
    {
        return $admin->can('view-roles');
    }

    // Can the admin create a product?
    public function create(Admin $admin): bool
    {
        return $admin->can('create-roles');
    }

    // Can the admin edit a product?
    public function update(Admin $admin, Role $role): bool
    {
        return $admin->can('edit-roles');
    }

    // Can the admin delete a product?
    public function delete(Admin $admin, Role $role): bool
    {
        return $admin->can('delete-roles');
    }

    // Can the admin toggle active a product?
    public function toggleActive(Admin $admin, Role $role): bool
    {
        return $admin->can('toggleActive-roles');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Role $role): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Role $role): bool
    {
        //
    }
}
