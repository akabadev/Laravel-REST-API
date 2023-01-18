<?php

namespace App\Http\Controllers\V0;

use Illuminate\Http\Client\Response as GuzzleResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class ROrderController extends BaseApiController
{
    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function resend(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall(
            $this->getLogiwebResourceClass(),
            'reSend'
        );
    }

    protected function getLogiwebResourceClass(): string
    {
        return 'S_ACOMMANDES';
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function getFile(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall(
            $this->getLogiwebResourceClass(),
            'GetPaieFile'
        );
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function reports(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall(
            $this->getLogiwebResourceClass(),
            'getRapports'
        );
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function sepaData(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall(
            $this->getLogiwebResourceClass(),
            'GetSepaDatas'
        );
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function sepaFile(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall(
            $this->getLogiwebResourceClass(),
            'GetSepaFile'
        );
    }

    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function rename(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardPostCall(
            $this->getLogiwebResourceClass(),
            'changeName'
        );
    }
}
