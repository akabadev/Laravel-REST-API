<?php

namespace App\Http\Controllers\V0;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class ValidationController extends BaseApiController
{
    /**
     * @return \Illuminate\Http\Client\Response|JsonResponse|Response
     * @throws Throwable
     */
    public function getFile(): Response|JsonResponse|\Illuminate\Http\Client\Response
    {
        return $this->forwardGetCall(
            $this->getLogiwebResourceClass(),
            'GetPaieFile'
        );
    }

    protected function getLogiwebResourceClass(): string
    {
        return 'S_VALIDATIONS';
    }
}
