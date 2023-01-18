<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Menu"),
 *     @OA\Property(property="sequence", type="integer", example="1"),
 *     @OA\Property(property="name", type="string", example="admin"),
 *     @OA\Property(property="title", type="string", example="1"),
 *     @OA\Property(property="active", type="boolean", example="true")
 * )
 *
 * Class Menu
 * @package App\Models
 *
 * @property string name
 * @property string title
 * @property integer sequence
 * @property boolean active
 * @property string[] payload
 */
class Menu extends Model
{
    protected $fillable = [
        "name",
        "title",
        "parent_id",
        "profile_id",
        "page_id",
        "sequence",
        "active",
        "payload"
    ];

    protected $casts = [
        "active" => "boolean",
        "payload" => "array",
    ];

    protected $hidden = ["profile_id", "page_id"];

    protected $appends = ["profile", "page"];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(fn (Builder|QueryBuilder $builder) => $builder->orderBy("sequence"));
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, "parent_id");
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * @param string|null $name
     * @return string|null
     */
    public function getNameAttribute(?string $name = null): ?string
    {
        return $name ?: $this->page->name;
    }

    /**
     * @param string|null $title
     * @return string|null
     */
    public function getTitleAttribute(?string $title = null): ?string
    {
        return $title ?? $this->page->name;
    }

    /**
     * @return Profile
     */
    public function getProfileAttribute(): Profile
    {
        return $this->profile()->firstOrFail();
    }

    /**
     * @return Page
     */
    public function getPageAttribute(): Page
    {
        return $this->page()->firstOrFail();
    }

    /**
     * @return $this|null
     */
    public function getParentAttribute(): ?self
    {
        return $this->parent()->firstOrFail();
    }

    public function scopeActive(Builder $builder)
    {
        return $builder->where("active", true);
    }

    public function scopeRoot(Builder $builder)
    {
        return $builder->whereNull('parent_id');
    }

    /**
     * @return Builder
     */
    public function children(): Builder
    {
        return self::where("parent_id", $this->id)
            ->where('profile_id', $this->profile_id)
            ->active();
    }

    /**
     * @param Menu|null $menu
     * @return array
     */
    private function menuFormater(?Menu $menu = null): array
    {
        $menu = $menu ?: $this;

        return [
            "name" => $menu->name,
            "page" => $menu->page_id,
            "label" => $menu->title,
            "icon" => $menu->payload['icon'] ?? '',
            "routerLink" => $menu->payload['route'] ?? '',
        ];
    }

    public function build(): array
    {
        $result = $this->menuFormater();

        $result['items'] = $this->children()->get()
            ->map(fn (Menu $menu) => $this->menuFormater($menu))
            ->values()->toArray();

        if (count($result['items']) === 0) {
            unset($result['items']);
        }

        return $result;
    }
}
