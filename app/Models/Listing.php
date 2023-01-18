<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Listing"),
 *     @OA\Property(property="code", type="string", example="2628772687"),
 *     @OA\Property(property="parent_id", type="integer", example="1"),
 *     @OA\Property(property="description", type="string", example="description text"),
 *     @OA\Property(property="notion", type="string", example="MorphToClass"),
 * )
 *
 * Class Listing
 *
 * @property int parent_id
 * @property string notion
 *
 * @package App\Models
 */
class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'listings';

    protected $fillable = ['code', 'parent_id', 'description', 'notion'];

    protected $hidden = [
        'notion',
        'deleted_at',
        'created_at',
        'updated_at',
        'parent_id',
    ];

    /**
     * Parent
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|self|null
     */
    public function next(): \Illuminate\Database\Eloquent\Model|self|null
    {
        return self::query()
            ->where('notion', $this->notion)
            ->where('parent_id', $this->id)
            ->first();
    }

    public function previous(): \Illuminate\Database\Eloquent\Model|self|null
    {
        return self::query()
            ->where('notion', $this->notion)
            ->where('id', $this->parent_id)
            ->first();
    }

    /**
     * @param array $attributes
     * @return Listing
     */
    public static function createManyRecursive(array $attributes): static
    {
        $child = Arr::pull($attributes, "child");
        $current = static::create(Arr::except($attributes, ['child']));
        return empty($child) ? $current : static::createManyRecursive(array_merge($child, ['parent_id' => $current->id]));
    }
}
