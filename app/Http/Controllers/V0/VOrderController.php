<?php

namespace App\Http\Controllers\V0;

class VOrderController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_VCOMMANDES';
    }
}
