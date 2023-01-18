<?php

namespace App\Http\Controllers\V0;

class AddressController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_ADRESSES';
    }
}
