<?php

namespace App\Models\Contracts;

interface Importable
{
    /**
     * @return array
     */
    public function importableData(): array;
}
