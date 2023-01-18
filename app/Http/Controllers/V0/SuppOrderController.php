<?php

namespace App\Http\Controllers\V0;

use Illuminate\Http\Client\Response as GuzzleResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class SuppOrderController extends BaseApiController
{
    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function validateOrder(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall(
            $this->getLogiwebResourceClass(),
            'Validate'
        );
    }

    protected function getLogiwebResourceClass(): string
    {
        return 'S_COMMANDES_SUPP';
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function validateAllOrders(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall(
            $this->getLogiwebResourceClass(),
            'ValidateAll'
        );
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function clean(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall(
            $this->getLogiwebResourceClass(),
            'Clean'
        );
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function orderState(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall(
            $this->getLogiwebResourceClass(),
            'GetState'
        );
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function newOrder(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall(
            $this->getLogiwebResourceClass(),
            'NewCommande'
        );
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function renameOrder(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall(
            $this->getLogiwebResourceClass(),
            'RenameCommande'
        );
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function recap(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall($this->getLogiwebResourceClass(), 'GetRecap');
    }
}
