<?php

namespace App\Http\Controllers\V0;

class AbsenceController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_ABSENCES_STD';
    }
}
