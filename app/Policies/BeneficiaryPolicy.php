<?php

namespace App\Policies;

use App\Models\Beneficiary;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BeneficiaryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Beneficiary $beneficiary
     * @return mixed
     */
    public function view(User $user, Beneficiary $beneficiary): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Beneficiary $beneficiary
     * @return mixed
     */
    public function update(User $user, Beneficiary $beneficiary): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Beneficiary $beneficiary
     * @return mixed
     */
    public function delete(User $user, Beneficiary $beneficiary): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Beneficiary $beneficiary
     * @return mixed
     */
    public function restore(User $user, Beneficiary $beneficiary): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Beneficiary $beneficiary
     * @return mixed
     */
    public function forceDelete(User $user, Beneficiary $beneficiary): Response
    {
        return Response::allow();
    }
}
