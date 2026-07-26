<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\ImpactStory;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

final class ImpactStoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ImpactStory');
    }

    public function view(AuthUser $authUser, ImpactStory $impactStory): bool
    {
        return $authUser->can('View:ImpactStory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ImpactStory');
    }

    public function update(AuthUser $authUser, ImpactStory $impactStory): bool
    {
        return $authUser->can('Update:ImpactStory');
    }

    public function delete(AuthUser $authUser, ImpactStory $impactStory): bool
    {
        return $authUser->can('Delete:ImpactStory');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ImpactStory');
    }

    public function restore(AuthUser $authUser, ImpactStory $impactStory): bool
    {
        return $authUser->can('Restore:ImpactStory');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ImpactStory');
    }

    public function forceDelete(AuthUser $authUser, ImpactStory $impactStory): bool
    {
        return $authUser->can('ForceDelete:ImpactStory');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ImpactStory');
    }
}
