<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     @OA\Xml(name="OrderDetail"),
 *     @OA\Property(property="quantity", type="integer", example="3"),
 *     @OA\Property(property="delivery_type", type="string", example="Delivery Type"),
 *     @OA\Property(property="order_id", type="integer", example="1"),
 *     @OA\Property(property="product_id", type="integer", example="2"),
 *     @OA\Property(property="beneficiary_id", type="integer", example="3"),
 *     @OA\Property(property="beneficiary", ref="#/components/schemas/Beneficiary"),
 *     @OA\Property(property="product", ref="#/components/schemas/Product"),
 *     @OA\Property(property="order", ref="#/components/schemas/Order"),
 * )
 *
 * Class OrderDetail
 * @package App\Models
 */
class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "quantity",
        "delivery_type",
        "order_id",
        "product_id",
        "beneficiary_id"
    ];

    protected $appends = ['order', 'product', 'beneficiary'];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getOrderAttribute(): Order
    {
        return $this->order()->firstOrFail();
    }

    public function getProductAttribute(): Product
    {
        return $this->product()->firstOrFail();
    }

    public function getBeneficiaryAttribute(): Beneficiary
    {
        return $this->beneficiary()->firstOrFail();
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeActiveBeneficiaries(Builder $builder): Builder
    {
        return $builder->join(
            'beneficiaries',
            'beneficiaries.id',
            '=',
            'order_details.beneficiary_id'
        )->where('beneficiaries.active', true);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeNotEmpty(Builder $builder): Builder
    {
        return $builder->where('quantity', '>', 0);
    }
}
