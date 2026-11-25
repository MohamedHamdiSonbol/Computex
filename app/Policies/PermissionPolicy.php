<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
{
    // Can the admin view the list of Permissions?
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view-permissions');
    }

    // Can the admin view a single Permission profile?
    public function view(Admin $admin, Permission $permission): bool
    {
        return $admin->can('view-permissions');
    }

    // Can the admin create a Permission?
    public function create(Admin $admin): bool
    {
        return $admin->can('create-permissions');
    }

    // Can the admin edit a Permission?
    public function update(Admin $admin, Permission $permission): bool
    {
        return $admin->can('edit-permissions');
    }

    // Can the admin delete a Permission?
    public function delete(Admin $admin, Permission $permission): bool
    {
        return $admin->can('delete-permissions');
    }

    // Can the admin toggle active a Permission?
    public function toggleActive(Admin $admin, Permission $permission): bool
    {
        return $admin->can('toggleActive-permissions');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Permission $permission): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Permission $permission): bool
    {
        //
    }
}
