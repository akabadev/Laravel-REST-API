<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Process"),
 *     @OA\Property(property="code", type="string", example="92879827-UII"),
 *     @OA\Property(property="description", type="string", example="Description..."),
 *     @OA\Property(property="invokable", type="string", example="MorphToClass"),
 * )
 *
 * Class Process
 * @package App\Models
 * @property string $invokable
 *
 */
class Process extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'description', 'invokable'];

    protected $hidden = [
        'invokable',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * @return HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * @param Carbon|null $date
     * @return HasMany
     */
    public function pendingTasks(?Carbon $date = null): HasMany
    {
        $date = $date ?: now();
        return $this->tasks()
            ->where('available_at', '<=', $date)
            ->where(function (Builder $builder) {
                return $builder->orWhereNull('limited_at')
                    ->orWhere('limited_at', '<=', now());
            })
            ->where('attempts', 0);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopePending(Builder $builder): Builder
    {
        return $builder->whereExists(function (\Illuminate\Database\Query\Builder $builder) {
            return $builder->select('process_id')
                ->join('tasks', 'tasks.process_id', '=', 'processes.id')
                ->where('attempts', 0)
                ->where('available_at', '<=', now()->addDay()->midDay());
        });
    }

    /**
     * @param string $model
     * @param string[] $attributes
     * @return Process
     */
    public static function findOrCreateWithInvokable(string $model, array $attributes = []): Process
    {
        return self::firstOrCreate(['invokable' => $model], $attributes);
    }
}
