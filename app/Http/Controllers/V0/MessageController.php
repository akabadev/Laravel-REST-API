<?php

namespace App\Http\Controllers\V0;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class MessageController extends BaseApiController
{
    /**
     * @return \Illuminate\Http\Client\Response|JsonResponse|Response
     * @throws Throwable
     */
    public function mine(): Response|JsonResponse|\Illuminate\Http\Client\Response
    {
        return $this->forwardGetCall(
            $this->getLogiwebResourceClass(),
            'GetMessages'
        );
    }

    protected function getLogiwebResourceClass(): string
    {
        return 'S_MESSAGES';
    }
}
