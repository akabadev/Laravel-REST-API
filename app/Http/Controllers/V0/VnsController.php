<?php

namespace App\Http\Controllers\V0;

class VnsController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_VNS';
    }
}
