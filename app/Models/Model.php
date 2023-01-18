<?php

namespace App\Models;

use DateTime;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *     @OA\Property(property="id", type="integer", description="Reseource ID", readOnly="true", example="1", readOnly="true")
 * )
 *
 * Class Model
 *
 * @package App\Models
 *
 * @method static Model findOrFail(int $id)
 * @method static Builder where($callable = null | $column = null, $operator = null, $s = null)
 * @method static Model find($id)
 * @method static Model findOrNew(array $fillable)
 * @method decrement($column, $amount = 1, $other = null)
 * @method increment($column, $amount = 1, $other = null)
 * @property int $id
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @method static static firstOrNew(array $fillable, array $second = [])
 * @method static Builder orderBy(string $column, $order = "asc")
 * @method static static latest()
 * @method static static updateOrCreate(array $matchs, $attribute = [])
 * @method static static create(array $fillable)
 * @method static static first()
 * @method static static firstOrFail($columns = ["*"])
 * @method static static firstOrCreate(array $fillable, array $array = [])
 * @method static count()
 * @method static LengthAwarePaginator paginate($perPage = null, $columns = ["*"], $pageName = "page", $page = null)
 */
abstract class Model extends BaseModel
{
    protected $hidden = [
        'email_verified_at',
        'deleted_at',
        'created_at',
        'updated_at',
        "password",
        'token',
        'api_token',
        'remember_token',
        'payload'
    ];

    /**
     * @param array $arrayOfAttributes [][]
     */
    public static function createMany(array $arrayOfAttributes = []): Collection
    {
        return collect($arrayOfAttributes)->map(fn ($attributes = []) => static::create($attributes));
    }

    /**
     * @param $column
     * @param Carbon|DateTime|null $dateTime
     * @return bool
     */
    public function tapDateTime($column, Carbon|DateTime|null $dateTime = null): bool
    {
        $dateTime = $dateTime ?: now();
        return $this->update([$column => $dateTime]);
    }

    /**
     * @param string $column
     * @param string $value
     * @param false $orFail
     * @return BaseModel|Builder
     */
    public static function findByColumn(string $column, string $value, bool $orFail = false): static
    {
        $query = static::query()->where($column, $value);
        return $orFail ? $query->firstOrFail() : $query->first();
    }
}
