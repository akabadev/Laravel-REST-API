<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Address"),
 *     @OA\Property(property="address_1", type="string", example="1 Rue du soleil"),
 *     @OA\Property(property="address_2", type="string", maxLength=32, example="Impasse XYZ"),
 *     @OA\Property(property="postal_code", type="integer", maxLength=32, example="94000"),
 *     @OA\Property(property="town", type="string", maxLength=32, example="Paris"),
 *     @OA\Property(property="country", type="string", maxLength=32, example="France"),
 * )
 *
 * Class Address
 * @package App\Models
 */
class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "address_1",
        "address_2",
        "postal_code",
        "town",
        "country",
    ];
}
