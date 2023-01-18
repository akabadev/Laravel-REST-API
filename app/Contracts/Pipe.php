<?php

namespace App\Contracts;

use Closure;

interface Pipe
{
    public function handle($content, Closure $next);
}
