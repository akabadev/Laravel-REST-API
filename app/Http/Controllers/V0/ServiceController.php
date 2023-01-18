<?php

namespace App\Http\Controllers\V0;

use Illuminate\Http\Client\Response as GuzzleResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class ServiceController extends BaseApiController
{
    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function importsFormat(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall(
            $this->getLogiwebResourceClass(),
            'GetFormat'
        );
    }

    /**
     * @return string
     */
    protected function getLogiwebResourceClass(): string
    {
        return 'S_SERVICES_STD';
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function importRsi(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall(
            $this->getLogiwebResourceClass(),
            'ImportRSI'
        );
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function getServices(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall(
            $this->getLogiwebResourceClass(),
            'GetServices'
        );
    }
}
