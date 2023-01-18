<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Period"),
 *     @OA\Property(property="name", type="string", example=" Period 2021"),
 *     @OA\Property(property="code", type="string", example="2628772687"),
 *     @OA\Property(property="calendar_id", type="integer", example="2"),
 *     @OA\Property(property="start_at", type="string", format="date-time", description="Starting timestamp", readOnly="true"),
 *     @OA\Property(property="end_at", type="string", format="date-time", description="Ending timestamp", readOnly="true"),
 *     @OA\Property(property="closed", type="boolean", example="true"),
 * )
 *
 * Class Period
 * @package App\Models
 */
class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        "code",
        "name",
        "calendar_id",
        "start_at",
        "end_at",
        "closed",
    ];
    
    /**
     * @return BelongsTo
     */
    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class);
    }
}
