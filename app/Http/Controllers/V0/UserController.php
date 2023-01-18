<?php

namespace App\Http\Controllers\V0;

use Illuminate\Http\Client\Response as GuzzleResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class UserController extends BaseApiController
{
    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function newPassword(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall($this->getLogiwebResourceClass(), 'newPassword');
    }

    protected function getLogiwebResourceClass(): string
    {
        return 'S_UTILISATEURS';
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function changePassword(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall($this->getLogiwebResourceClass(), 'changePassword');
    }

    /**
     * @return Response|JsonResponse
     * @throws Throwable
     */
    public function submitFile(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall($this->getLogiwebResourceClass(), 'sendDeposeFichier');
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function notifyEmail(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall($this->getLogiwebResourceClass(), 'sendAMail');
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function current(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall($this->getLogiwebResourceClass(), 'GetUser');
    }
}
