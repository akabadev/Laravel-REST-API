<?php

namespace App\Models;

use App\Models\Concerns\IsExportable;
use App\Models\Contracts\Exportable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Order"),
 *     @OA\Property(property="reference", type="string", example="92879827-UII"),
 *     @OA\Property(property="type", type="string", example="Type"),
 *     @OA\Property(property="tracking_number", type="string", example="John Doe"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="validated_at", type="string", format="date-time", description="Validation timestamp", readOnly="true"),
 *     @OA\Property(property="transmitted_at", type="string", format="date-time", description="Transmission timestamp", readOnly="true"),
 *     @OA\Property(property="produced_at", type="string", format="date-time", description="Production timestamp", readOnly="true"),
 *     @OA\Property(property="shipped_at", type="string", format="date-time", description="Shippment timestamp", readOnly="true"),
 *     @OA\Property(property="active", type="boolean", example="true"),
 *     @OA\Property(property="customer_id", type="integer", example="1")
 * )
 *
 * Class Order
 * @package App\Models
 *
 * @property Carbon validated_at
 */
class Order extends Model implements Exportable
{
    use HasFactory, SoftDeletes;
    use IsExportable;

    public const EXPORT_CODE_FIXED_SIZE = 'logidom_v1';

    protected $fillable = [
        "reference",
        "type",
        "tracking_number",
        "status",
        "validated_at",
        "generated_at",
        "transmitted_at",
        "produced_at",
        "shipped_at",
        "active",
        "customer_id",
    ];

    public function getHidden()
    {
        return array_merge($this->hidden, ["customer_id"]);
    }

    protected $casts = ['active' => 'boolean'];

    protected $appends = ['customer'];

    /**
     * @return MorphMany
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
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
    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getCustomerAttribute()
    {
        return $this->customer()->get();
    }

    public function getDetailsAttribute()
    {
        return $this->details()->get();
    }

    public function validated(): bool
    {
        return $this->validated_at != null;
    }
}
