<?php

namespace App\Contracts\IO\Import\Pipes;

use App\Contracts\Pipe;
use Closure;

class AssociateDataToRuleFields implements Pipe
{
    public function __construct(private array $rules)
    {
    }

    /**
     * @param $content
     * @param Closure $next
     * @return mixed
     */
    public function handle($content, Closure $next): mixed
    {
        $columns = array_keys($this->rules);
        $data = [];

        foreach ($columns as $key => $column) {
            data_set($data, $column, $content[$key] ?? null);
        }

        return $next($data);
    }
}
