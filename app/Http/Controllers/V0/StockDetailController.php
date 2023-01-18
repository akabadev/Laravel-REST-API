<?php

namespace App\Http\Controllers\V0;

class StockDetailController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_STOCK_DETAIL';
    }
}
