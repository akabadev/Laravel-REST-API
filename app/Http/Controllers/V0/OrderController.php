<?php

namespace App\Http\Controllers\V0;

use Illuminate\Http\Client\Response as GuzzleResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class OrderController extends BaseApiController
{
    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function orderState(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall($this->getLogiwebResourceClass(), 'GetState');
    }

    protected function getLogiwebResourceClass(): string
    {
        return 'S_COMMANDES_STD';
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function validateOrder(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall($this->getLogiwebResourceClass(), 'Validate');
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function validateAllOrders(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall($this->getLogiwebResourceClass(), 'ValidateAll');
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function lastOrderNumber(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall($this->getLogiwebResourceClass(), 'GetLastNumber');
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function ordersInfo(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall($this->getLogiwebResourceClass(), 'GetInfoCommande');
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function clean(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall($this->getLogiwebResourceClass(), 'Clean');
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function apply(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall($this->getLogiwebResourceClass(), 'Apply');
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
