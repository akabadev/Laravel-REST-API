<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

/**
 * @OA\Schema(
 *     @OA\Xml(name="PersonalAccessToken"),
 *     @OA\Property(property="name", type="string", example="Token Name"),
 *     @OA\Property(property="abilities", type="array", example="['*']", @OA\Items())
 * )
 *
 * Class PersonalAccessToken
 * @package App\Models
 *
 * @method static generated()
 */
class PersonalAccessToken extends SanctumPersonalAccessToken
{
    const GENERATED_TOKEN_NAME = 'token-via-api';
    const MAIN_APP_TOKEN_NAME = 'auth-token-main-app';
    const TENANT_APP_TOKEN_NAME = 'auth-token-tenant-app';

    protected $hidden = [
        'token',
        'tokenable_type',
        'tokenable_id',
        'created_at',
        'updated_at',
    ];

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeGenerated(Builder $query): Builder
    {
        return $query->where('name', self::GENERATED_TOKEN_NAME);
    }

    /**
     * @return bool
     */
    public function isGenerated(): bool
    {
        return $this->name === self::GENERATED_TOKEN_NAME;
    }

    public function toArray(): array
    {
        return ['tokenable' => $this->tokenable] + parent::toArray();
    }
}
