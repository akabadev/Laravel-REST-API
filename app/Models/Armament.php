<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Armament"),
 *     @OA\Property(property="spacecraft_id", type="integer", example="9287982"),
 *     @OA\Property(property="title", type="string", example="Tractor Beam"),
 *     @OA\Property(property="qty", type="integer",  maxLength=32, example="1"),
 *     @OA\Property(property="armament", ref="#/components/schemas/Armament"),
 * )
 *
 * Class Armament
 * @package App\Models
 */
class Armament extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'title',
        'qty'
    ];

    public function spacecraft(): BelongsTo
    {
        return $this->belongsTo(Spacecraft::class);
    }
}
