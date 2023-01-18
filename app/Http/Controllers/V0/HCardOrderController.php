<?php

namespace App\Http\Controllers\V0;

class HCardOrderController extends BaseApiController
{
    /**
     * @return string
     */
    protected function getLogiwebResourceClass(): string
    {
        return 'S_HCOMMANDES_CARTE';
    }
}
