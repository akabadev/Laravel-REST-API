<?php

namespace App\Http\Controllers\V0;

class HAbsenceController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_HABSENCES';
    }
}
