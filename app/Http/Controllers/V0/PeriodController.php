<?php

namespace App\Http\Controllers\V0;

class PeriodController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_PERIODES';
    }
}
