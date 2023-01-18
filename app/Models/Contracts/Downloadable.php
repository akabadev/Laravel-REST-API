<?php

namespace App\Models\Contracts;

interface Downloadable
{
    /**
     * @return string|null
     */
    public function filePath(): ?string;

    /**
     * @return bool
     */
    public function isReady(): bool;
}
