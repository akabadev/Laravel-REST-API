<?php

namespace App\Http\Controllers\V0;

class ProfileController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_PROFILS';
    }
}
