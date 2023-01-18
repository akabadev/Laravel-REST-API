<?php

namespace App\Models\Contracts;

interface Exportable
{
    /**
     * @return array
     */
    public function exportableData(): array;


    /**
     * @return array
     */
    public function exportableColumns(): array;
}
