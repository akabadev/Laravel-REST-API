<?php

namespace App\Http\Controllers\V0;

class PaymentController extends BaseApiController
{
    protected function getLogiwebResourceClass(): string
    {
        return 'S_PAIEMENTS';
    }
}
