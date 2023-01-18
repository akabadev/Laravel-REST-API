<?php

namespace App\Policies;

use App\Models\Template;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TemplatePolicy
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
        return Response::deny();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Template $template
     * @return Response
     */
    public function view(User $user, Template $template): Response
    {
        return Response::deny();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response
     */
    public function create(User $user): Response
    {
        return Response::deny();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Template $template
     * @return Response
     */
    public function update(User $user, Template $template): Response
    {
        return Response::deny();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Template $template
     * @return Response
     */
    public function delete(User $user, Template $template): Response
    {
        return Response::deny();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Template $template
     * @return Response
     */
    public function restore(User $user, Template $template): Response
    {
        return Response::deny();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Template $template
     * @return Response
     */
    public function forceDelete(User $user, Template $template): Response
    {
        return Response::deny();
    }
}
