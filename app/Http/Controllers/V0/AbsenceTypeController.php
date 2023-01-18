<?php

namespace App\Http\Controllers\V0;

class AbsenceTypeController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_TYPES_ABSENCES';
    }
}
