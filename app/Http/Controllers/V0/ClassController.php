<?php

namespace App\Http\Controllers\V0;

class ClassController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_CLASSES';
    }
}
