<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as TenantBase;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Template"),
 *     @OA\Property(property="id", type="string", example="orange"),
 *     @OA\Property(property="data", type="array", example="[]", @OA\Items())
 * )
 *
 * Class Tenant
 * @package App\Models
 *
 * @method static Tenant create(array $array)
 * @method static Tenant firstOrCreate(array $array)
 * @method static Tenant findOrFail(string $name)
 *
 * @property int $template_id
 * @property Template $template
 */
class Tenant extends TenantBase implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    protected static function boot()
    {
        parent::boot();

        self::created(function (self $tenant) {
            if (null === $tenant->template_id) {
                $tenant->update(['template_id' => TenantTemplate::DEFAULT_TEMPLATE_ID]);
            }
        });
    }

    /**
     * @return BelongsTo
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(TenantTemplate::class);
    }
}
