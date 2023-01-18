<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     @OA\Xml(name="TenantTemplate"),
 *     @OA\Property(property="name", type="string", example="Tenant Template name")
 * )
 *
 * Class Template
 * @package App\Models
 */
class TenantTemplate extends Model
{
    const DEFAULT_TEMPLATE_ID = 1;
    protected $fillable = ['name'];

    use HasFactory;

    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }
}
