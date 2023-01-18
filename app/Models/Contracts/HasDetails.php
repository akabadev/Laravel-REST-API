<?php

namespace App\Models\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface HasDetails
{
    /**
     * @return array|Arrayable
     */
    public function getDetails(): array|Arrayable;
}
