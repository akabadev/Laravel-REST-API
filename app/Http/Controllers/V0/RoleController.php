<?php

namespace App\Http\Controllers\V0;

class RoleController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_UPROFILS';
    }
}
