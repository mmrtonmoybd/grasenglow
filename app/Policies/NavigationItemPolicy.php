<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\NavigationItem;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

final class NavigationItemPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:NavigationItem');
    }

    public function view(AuthUser $authUser, NavigationItem $navigationItem): bool
    {
        return $authUser->can('View:NavigationItem');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:NavigationItem');
    }

    public function update(AuthUser $authUser, NavigationItem $navigationItem): bool
    {
        return $authUser->can('Update:NavigationItem');
    }

    public function delete(AuthUser $authUser, NavigationItem $navigationItem): bool
    {
        return $authUser->can('Delete:NavigationItem');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:NavigationItem');
    }

    public function restore(AuthUser $authUser, NavigationItem $navigationItem): bool
    {
        return $authUser->can('Restore:NavigationItem');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:NavigationItem');
    }

    public function forceDelete(AuthUser $authUser, NavigationItem $navigationItem): bool
    {
        return $authUser->can('ForceDelete:NavigationItem');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:NavigationItem');
    }
}
