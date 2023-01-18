<?php

namespace App\Http\Controllers\V0;

class StockController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_STOCK';
    }
}
