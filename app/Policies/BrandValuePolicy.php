<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\BrandValue;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

final class BrandValuePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:BrandValue');
    }

    public function view(AuthUser $authUser, BrandValue $brandValue): bool
    {
        return $authUser->can('View:BrandValue');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:BrandValue');
    }

    public function update(AuthUser $authUser, BrandValue $brandValue): bool
    {
        return $authUser->can('Update:BrandValue');
    }

    public function delete(AuthUser $authUser, BrandValue $brandValue): bool
    {
        return $authUser->can('Delete:BrandValue');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:BrandValue');
    }

    public function restore(AuthUser $authUser, BrandValue $brandValue): bool
    {
        return $authUser->can('Restore:BrandValue');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:BrandValue');
    }

    public function forceDelete(AuthUser $authUser, BrandValue $brandValue): bool
    {
        return $authUser->can('ForceDelete:BrandValue');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:BrandValue');
    }
}
