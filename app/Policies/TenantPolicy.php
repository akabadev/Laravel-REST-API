<?php

namespace App\Policies;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TenantPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response
     */
    public function viewAny(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Tenant $tenant
     * @return Response
     */
    public function view(User $user, Tenant $tenant): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response
     */
    public function create(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Tenant $tenant
     * @return Response
     */
    public function update(User $user, Tenant $tenant): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Tenant $tenant
     * @return Response
     */
    public function delete(User $user, Tenant $tenant): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Tenant $tenant
     * @return Response
     */
    public function restore(User $user, Tenant $tenant): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Tenant $tenant
     * @return Response
     */
    public function forceDelete(User $user, Tenant $tenant): Response
    {
        return Response::allow();
    }
}
