<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Calendar"),
 *     @OA\Property(property="name", type="string", example=" Calendar 2021"),
 *     @OA\Property(property="code", type="string", example="2628772687"),
 *     @OA\Property(property="period_type", type="string", format="date-time", description="Period timestamp", readOnly="true"),
 *     @OA\Property(property="start_at", type="string", format="date-time", description="Starting timestamp", readOnly="true"),
 *     @OA\Property(property="end_at", type="string", format="date-time", description="Ending timestamp", readOnly="true"),
 *     @OA\Property(property="active", type="boolean", example="true"),
 * )
 *
 * Class Calendar
 * @package App\Models
 */
class Calendar extends Model
{
    use HasFactory;

    public const PERIOD_TYPES = ['days', 'weeks', 'months', 'trimesters', 'years'];

    protected $fillable = [
        "code",
        "name",
        "period_type",
        "start_at",
        "end_at",
        "active",
    ];

    /**
    * @return HasMany
    */
    public function periods(): HasMany
    {
        return $this->hasMany(Period::class);
    }
}
