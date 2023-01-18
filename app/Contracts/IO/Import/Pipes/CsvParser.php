<?php

namespace App\Contracts\IO\Import\Pipes;

use App\Contracts\Pipe;
use Closure;

class CsvParser implements Pipe
{
    public function __construct(private $separator = ';')
    {
    }

    /**
     * @param $content
     * @param Closure $next
     * @return mixed
     */
    public function handle($content, Closure $next): mixed
    {
        $data = array_map(
            fn ($item) => trim($item),
            str_getcsv($content, $this->separator),
        );

        return $next($data);
    }
}
