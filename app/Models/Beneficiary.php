<?php

namespace App\Models;

use App\Models\Concerns\IsExportable;
use App\Models\Contracts\Exportable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Beneficiary"),
 *     @OA\Property(property="code", type="string", example="1234567890"),
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="email", type="string", example="john.doe@up.coop"),
 *     @OA\Property(property="profile", type="string", example="Admin"),
 *     @OA\Property(property="active", type="boolean", example="true"),
 *     @OA\Property(property="address_id", type="integer", example="1"),
 *     @OA\Property(property="service_id", type="integer", example="2")
 * )
 *
 * Class Beneficiary
 * @package App\Models
 */
class Beneficiary extends Model implements Exportable
{
    use HasFactory, SoftDeletes;
    use IsExportable;

    public static $PROFILES = ["admin", "standard", "customer"];

    protected $fillable = [
        "code",
        "first_name",
        "last_name",
        "email",
        "profile",
        "active",
        "address_id",
        "service_id",
    ];

    protected $appends = ["full_name"];

    /**
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * @return BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function getFullNameAttribute(): string
    {
        return "$this->first_name $this->last_name";
    }
}
