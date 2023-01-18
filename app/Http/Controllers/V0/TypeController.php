<?php

namespace App\Http\Controllers\V0;

class TypeController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_TYPES';
    }
}
