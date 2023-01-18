<?php

namespace App\Models;

use App\Models\Concerns\IsExportable;
use App\Models\Contracts\Exportable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Customer"),
 *     @OA\Property(property="code", type="string", example="2628772687"),
 *     @OA\Property(property="bo_reference", type="string", example="92879827-UII"),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="contact_name", type="string", example="John Doe"),
 *     @OA\Property(property="active", type="boolean", example="true"),
 *     @OA\Property(property="address_id", type="integer", example="1"),
 *     @OA\Property(property="address", ref="#/components/schemas/Address")
 * )
 *
 * Class Customer
 * @package App\Models
 */
class Customer extends Model implements Exportable
{
    use HasFactory, SoftDeletes;
    use IsExportable;

    protected $fillable = [
        "code",
        "bo_reference",
        "name",
        "contact_name",
        "active",
        "address_id",
    ];

    protected $appends = ["address"];

    protected $casts = [
        "active" => "boolean"
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * @return HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function getAddressAttribute()
    {
        return $this->address()->get();
    }
}
