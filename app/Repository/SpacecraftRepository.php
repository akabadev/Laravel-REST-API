<?php

namespace App\Repository;


use App\Models\Spacecraft;
use App\Models\Model as BaseModel;
use Illuminate\Database\Eloquent\Model;

use App\Repository\Contracts\Interfaces\SpacecraftRepositoryInterface;
use App\Repository\Contracts\Repository;

/**
 * Class AddressRepository
 * @package App\Repository
 */
class SpacecraftRepository extends Repository implements SpacecraftRepositoryInterface
{
   
    /**
     * @param int|Spacecraft $model
     * @param false $force
     * @return bool
     */
    public function delete(Model|int $model, bool $force = false): bool
    {
        if (is_int($model)) {
            $model = Spacecraft::findOrFail($model);
        }

        return parent::delete($model, $force);
    }


}
