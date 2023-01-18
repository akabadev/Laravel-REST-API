<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Product"),
 *     @OA\Property(property="code", type="string", example="92879827-UII"),
 *     @OA\Property(property="name", type="string", example="Name"),
 *     @OA\Property(property="price", type="double", example="25.5"),
 *     @OA\Property(property="price_share", type="double", example="2.5"),
 *     @OA\Property(property="active", type="boolean", example="true"),
 * )
 *
 * Class Product
 * @package App\Models
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    public const PRODUCT_TYPE_PAPER = 'PAPIER';
    public const PRODUCT_TYPE_3C = 'CARTE_3C';
    public const PRODUCT_TYPE_4C = 'CARTE_4C';

    protected $fillable = [
        "code",
        "name",
        "price",
        "price_share",
        "active",
    ];

    protected $appends = ["price_share_in_cent"];

    public function getPriceShareInCentAttribute()
    {
        return $this->price_share * 100;
    }
}
