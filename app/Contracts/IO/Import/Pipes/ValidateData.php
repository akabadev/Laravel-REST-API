<?php

namespace App\Contracts\IO\Import\Pipes;

use App\Contracts\Pipe;
use Closure;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ValidateData implements Pipe
{
    public function __construct(private array $rules)
    {
    }

    /**
     * @param $content
     * @param Closure $next
     * @return array
     * @throws ValidationException
     */
    public function handle($content, Closure $next)
    {
        return Validator::make($content, $this->rules)->validated();
    }
}
