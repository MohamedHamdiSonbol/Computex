<?php

namespace App\Policies;

use App\Models\Attribute;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class AttributePolicy
{
    // Can the admin view the list of products?
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view-attributes');
    }

    // Can the admin view a single product profile?
    public function view(Admin $admin, Attribute $attribute): bool
    {
        return $admin->can('view-attributes');
    }

    // Can the admin create a product?
    public function create(Admin $admin): bool
    {
        return $admin->can('create-attributes');
    }

    // Can the admin edit a product?
    public function update(Admin $admin, Attribute $attribute): bool
    {
        return $admin->can('edit-attributes');
    }

    // Can the admin delete a product?
    public function delete(Admin $admin, Attribute $attribute): bool
    {
        return $admin->can('delete-attributes');
    }

    // Can the admin toggle active a product?
    public function toggleActive(Admin $admin, Attribute $attribute): bool
    {
        return $admin->can('toggleActive-attributes');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Attribute $attribute): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Attribute $attribute): bool
    {
        //
    }
}
