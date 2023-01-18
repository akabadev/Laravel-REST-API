<?php

namespace App\Http\Controllers\V0;

class TypeAbsenceController extends BaseApiController
{
    /**
     * @return string
     */
    protected function getLogiwebResourceClass(): string
    {
        return 'S_TYPES_ABSENCES';
    }
}
