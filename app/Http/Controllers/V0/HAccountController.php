<?php

namespace App\Http\Controllers\V0;

class HAccountController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_DCOMPTES';
    }
}
