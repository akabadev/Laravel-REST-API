<?php

namespace App\Http\Controllers\V0;

class ImportController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_IMPORT';
    }
}
