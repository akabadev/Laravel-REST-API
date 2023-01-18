<?php

namespace App\Http\Controllers\V0;

use Illuminate\Http\Client\Response as GuzzleResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class HOrderController extends BaseApiController
{
    /**
     * @return GuzzleResponse|JsonResponse|Response
     * @throws Throwable
     */
    public function fetch(): Response|JsonResponse|GuzzleResponse
    {
        return $this->forwardGetCall(
            $this->getLogiwebResourceClass(),
            'GetCommandes'
        );
    }

    protected function getLogiwebResourceClass(): string
    {
        return 'S_HCOMMANDES';
    }
}
