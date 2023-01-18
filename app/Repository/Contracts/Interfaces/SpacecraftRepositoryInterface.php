<?php


namespace App\Repository\Contracts\Interfaces;

use App\Models\Spacecraft;
use App\Models\Model;

interface SpacecraftRepositoryInterface extends RepositoryInterface
{
    
    /**
     * @param Model|int $model
     * @param bool $force
     * @return bool
     */
    public function delete(Model|int $model, bool $force = false): bool;
}