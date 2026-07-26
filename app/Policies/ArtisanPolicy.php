<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Artisan;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

final class ArtisanPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Artisan');
    }

    public function view(AuthUser $authUser, Artisan $artisan): bool
    {
        return $authUser->can('View:Artisan');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Artisan');
    }

    public function update(AuthUser $authUser, Artisan $artisan): bool
    {
        return $authUser->can('Update:Artisan');
    }

    public function delete(AuthUser $authUser, Artisan $artisan): bool
    {
        return $authUser->can('Delete:Artisan');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Artisan');
    }

    public function restore(AuthUser $authUser, Artisan $artisan): bool
    {
        return $authUser->can('Restore:Artisan');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Artisan');
    }

    public function forceDelete(AuthUser $authUser, Artisan $artisan): bool
    {
        return $authUser->can('ForceDelete:Artisan');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Artisan');
    }
}
