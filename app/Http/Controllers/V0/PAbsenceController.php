<?php

namespace App\Http\Controllers\V0;

class PAbsenceController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_PABSENCES';
    }
}
