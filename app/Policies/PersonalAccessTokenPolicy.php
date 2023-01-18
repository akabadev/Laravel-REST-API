<?php

namespace App\Policies;

use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PersonalAccessTokenPolicy
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
     * @param PersonalAccessToken $token
     * @return Response
     */
    public function view(User $user, PersonalAccessToken $token): Response
    {
        return $token->isGenerated() ? Response::allow() : Response::deny();
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
     * @param PersonalAccessToken $token
     * @return Response
     */
    public function update(User $user, PersonalAccessToken $token): Response
    {
        return $token->isGenerated() ? Response::allow() : Response::deny();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param PersonalAccessToken $token
     * @return Response
     */
    public function delete(User $user, PersonalAccessToken $token): Response
    {
        return $token->isGenerated() ? Response::allow() : Response::deny();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param PersonalAccessToken $token
     * @return Response
     */
    public function restore(User $user, PersonalAccessToken $token): Response
    {
        return $token->isGenerated() ? Response::allow() : Response::deny();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param PersonalAccessToken $token
     * @return Response
     */
    public function forceDelete(User $user, PersonalAccessToken $token): Response
    {
        return $token->isGenerated() ? Response::allow() : Response::deny();
    }
}
