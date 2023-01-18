<?php

namespace App\Http\Controllers\V0;

class PrevAbsenceController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_PREV_ABSENCES';
    }
}
