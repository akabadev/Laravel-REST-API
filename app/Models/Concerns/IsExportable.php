<?php

namespace App\Models\Concerns;

trait IsExportable
{
    /**
     * @return array
     */
    public function exportableData(): array
    {
        return $this->toArray();
    }

    /**
     * @return array
     */
    public function exportableColumns(): array
    {
        return [];
    }
}
