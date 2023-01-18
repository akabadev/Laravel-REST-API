<?php

namespace App\Http\Controllers\V0;

class ProfilePageController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_MENUS';
    }
}
