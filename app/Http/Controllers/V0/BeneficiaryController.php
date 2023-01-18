<?php

namespace App\Http\Controllers\V0;

use Illuminate\Http\Client\Response as GuzzleResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class BeneficiaryController extends BaseApiController
{
    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function activateAll(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall(
            $this->getLogiwebResourceClass(),
            'ActivateAll'
        );
    }

    protected function getLogiwebResourceClass(): string
    {
        return 'S_BENEFICIAIRES_STD';
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function transfer(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall(
            $this->getLogiwebResourceClass(),
            'Transfert'
        );
    }

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
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function getBeneficiaries(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall(
            $this->getLogiwebResourceClass(),
            'GetBenefs'
        );
    }
}
