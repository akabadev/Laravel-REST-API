<?php

namespace App\Http\Controllers\V0;

class ProfessionController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_METIERS';
    }
}
