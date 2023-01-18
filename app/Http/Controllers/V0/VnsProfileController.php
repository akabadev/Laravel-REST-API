<?php

namespace App\Http\Controllers\V0;

class VnsProfileController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_VNPROFILS';
    }
}
