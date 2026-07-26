<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\ResearchPublication;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

final class ResearchPublicationPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ResearchPublication');
    }

    public function view(AuthUser $authUser, ResearchPublication $researchPublication): bool
    {
        return $authUser->can('View:ResearchPublication');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ResearchPublication');
    }

    public function update(AuthUser $authUser, ResearchPublication $researchPublication): bool
    {
        return $authUser->can('Update:ResearchPublication');
    }

    public function delete(AuthUser $authUser, ResearchPublication $researchPublication): bool
    {
        return $authUser->can('Delete:ResearchPublication');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ResearchPublication');
    }

    public function restore(AuthUser $authUser, ResearchPublication $researchPublication): bool
    {
        return $authUser->can('Restore:ResearchPublication');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ResearchPublication');
    }

    public function forceDelete(AuthUser $authUser, ResearchPublication $researchPublication): bool
    {
        return $authUser->can('ForceDelete:ResearchPublication');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ResearchPublication');
    }
}
