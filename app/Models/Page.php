<?php

namespace App\Models;

use App\Contracts\IO\Views\ViewsConfiguration;
use App\Models\Concerns\HasCode;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Page"),
 *     @OA\Property(property="code", type="string", description="Page unique code", example="123456789-AZERTYUI-12345678"),
 *     @OA\Property(property="name", type="string", description="Page unique name", example="Home"),
 *     @OA\Property(property="title", type="string", description="Page unique title", example="Home Page"),
 *     @OA\Property(property="sequence", type="string", description="Order position", example="1"),
 *     @OA\Property(property="active", type="boolean", example="true"),
 *     @OA\Property(property="parent", type="array", @OA\Items(type="object", ref="#/components/schemas/Page"))
 * )
 *
 * Class Page
 * @package App\Models
 */
class Page extends Model
{
    use HasCode;

    protected $fillable = [
        "code",
        "name",
        "description",
        "active",
        "payload",
    ];

    protected $casts = ["active" => "boolean", "payload" => "array"];

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function config(): array
    {
        $file = $this->payload['config'] ?? "$this->code.json";
        $base = client_config("pages/$file");
        $hidden = data_get($base, "hidden");
        $base = Arr::except($base, "hidden");

        return ViewsConfiguration::getInstance()->getConfiguration($base, data_get($hidden, 'VALIDATOR_CODE'));
    }
}
