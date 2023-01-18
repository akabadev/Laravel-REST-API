<?php

namespace App\Models;

use App\Models\Concerns\HasCode;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Profile"),
 *     @OA\Property(property="code", type="string", example="1234567890"),
 *     @OA\Property(property="name", type="string", example="admin"),
 *     @OA\Property(property="level", type="int", example="1"),
 *     @OA\Property(property="authenticable", type="boolean", example="true"),
 *     @OA\Property(property="active", type="boolean", example="true"),
 * )
 *
 * Class Profile
 * @package App\Models
 */
class Profile extends Model
{
    use SoftDeletes;
    use HasCode;

    protected $fillable = [
        "code",
        "name",
        "level",
        "authenticable",
        "active",
    ];

    protected $casts = [
        "authenticable" => "bool",
        "active" => "bool"
    ];

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function views(): BelongsToMany
    {
        return $this->belongsToMany(Page::class, "menus");
    }

    /**
     * @return HasMany
     */
    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }
}
