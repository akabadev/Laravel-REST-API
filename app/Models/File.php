<?php

namespace App\Models;

use App\Contracts\IO\WritableFile;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

/**
 * @OA\Schema(
 *     @OA\Xml(name="File"),
 *     @OA\Property(property="name", type="string", example="2628772687"),
 *     @OA\Property(property="path", type="string", example="tenants/Basic/storage/exports/orders/test.csv"),
 *     @OA\Property(property="fileable_type", type="string", example="Order"),
 *     @OA\Property(property="fileable_id", type="integer", example="1"),
 * )
 *
 * Class File
 * @package App\Models
 */
class File extends Model
{
    protected $fillable = [
        "name",
        "path",
        "fileable_type",
        "fileable_id",
    ];

    private WritableFile|null $writable = null;

    /**
     * @return MorphTo
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @param Model $morph
     * @param Pattern|string $pattern
     * @param string|null $path
     * @param array $replaces
     * @param string $directory
     * @return static
     */
    public static function createWithMorph(Model $morph, Pattern|string $pattern, string $path = null, array $replaces = [], string $directory = 'exports'): static
    {
        $pattern = is_string($pattern) ? Pattern::findByCode($pattern) : $pattern;

        $path = $path ?: client_storage($directory . DIRECTORY_SEPARATOR . $pattern->stringOf($replaces));

        return static::create([
            'path' => Str::after($path, base_path()),
            'fileable_type' => $morph::class,
            'fileable_id' => $morph->id
        ]);
    }

    /**
     * @param string $mode
     * @return WritableFile
     */
    public function getWritable(string $mode = "w+"): WritableFile
    {
        return $this->writable ?: $this->writable = new WritableFile(base_path($this->path), $mode);
    }

    /**
     * @return string
     */
    public function fullPath(): string
    {
        return realpath(base_path($this->path));
    }
}
