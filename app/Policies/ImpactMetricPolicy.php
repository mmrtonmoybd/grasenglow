<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\ImpactMetric;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

final class ImpactMetricPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ImpactMetric');
    }

    public function view(AuthUser $authUser, ImpactMetric $impactMetric): bool
    {
        return $authUser->can('View:ImpactMetric');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ImpactMetric');
    }

    public function update(AuthUser $authUser, ImpactMetric $impactMetric): bool
    {
        return $authUser->can('Update:ImpactMetric');
    }

    public function delete(AuthUser $authUser, ImpactMetric $impactMetric): bool
    {
        return $authUser->can('Delete:ImpactMetric');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ImpactMetric');
    }

    public function restore(AuthUser $authUser, ImpactMetric $impactMetric): bool
    {
        return $authUser->can('Restore:ImpactMetric');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ImpactMetric');
    }

    public function forceDelete(AuthUser $authUser, ImpactMetric $impactMetric): bool
    {
        return $authUser->can('ForceDelete:ImpactMetric');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ImpactMetric');
    }
}
