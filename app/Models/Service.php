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
 *     @OA\Xml(name="Service"),
 *     @OA\Property(property="code", type="string", example="92879827-UII"),
 *     @OA\Property(property="bo_reference", type="string", example="UY666666-899"),
 *     @OA\Property(property="customer_id", type="integer", example="1"),
 *     @OA\Property(property="name", type="string", example="Tim Cook"),
 *     @OA\Property(property="contact_name", type="string", example="Tim Cook"),
 *     @OA\Property(property="address_id", type="integer", example="1"),
 *     @OA\Property(property="delivery_site", type="string", example="Siège d'Apple"),
 *     @OA\Property(property="active", type="boolean", example="true"),
 *     @OA\Property(property="address", ref="#/components/schemas/Address"),
 *     @OA\Property(property="customer", ref="#/components/schemas/Customer")
 * )
 *
 * Class Service
 * @package App\Models
 */
class Service extends Model implements Exportable
{
    use HasFactory, SoftDeletes;
    use IsExportable;

    protected $fillable = [
        "code",
        "bo_reference",
        "customer_id",
        "name",
        "contact_name",
        "address_id",
        "delivery_site",
        "active",
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

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
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return HasMany
     */
    public function beneficiaries(): HasMany
    {
        return $this->hasMany(Beneficiary::class);
    }
}
