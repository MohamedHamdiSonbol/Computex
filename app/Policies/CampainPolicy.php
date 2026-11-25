<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Campaign;
use Illuminate\Auth\Access\Response;

class CampainPolicy
{
    // Can the admin view the list of products?
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view-campaigns');
    }

    // Can the admin view a single product profile?
    public function view(Admin $admin, Campaign $campaign): bool
    {
        return $admin->can('view-campaigns');
    }

    // Can the admin create a product?
    public function create(Admin $admin): bool
    {
        return $admin->can('create-campaigns');
    }

    // Can the admin edit a product?
    public function update(Admin $admin, Campaign $campaign): bool
    {
        return $admin->can('edit-campaigns');
    }

    // Can the admin delete a product?
    public function delete(Admin $admin, Campaign $campaign): bool
    {
        return $admin->can('delete-campaigns');
    }

    // Can the admin toggle active a product?
    public function toggleActive(Admin $admin, Campaign $campaign): bool
    {
        return $admin->can('toggleActive-campaigns');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Campaign $campaign): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Campaign $campaign): bool
    {
        //
    }
}
