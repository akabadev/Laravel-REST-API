<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Pattern"),
 *     @OA\Property(property="code", type="string", example="AZERTYUI-9090-QSDFG"),
 *     @OA\Property(property="pattern", type="string", example="EXPORT_[USER]_[JJ][MM][AAAA].csv"),
 *     @OA\Property(property="description", type="string", example="nomenclatures fichiers des exports")
 * )
 *
 * Class Pattern
 * @package App\Models
 *
 * @property string pattern
 * @property string code
 * @property string description
 */
class Pattern extends Model
{
    protected $fillable = [
        "code",
        "pattern",
        "description"
    ];

    /**
     * @param string $code
     * @return static
     */
    public static function findByCode(string $code): static
    {
        return static::where("code", $code)->firstOrFail();
    }

    /**
     * @param string[] $replaces
     */
    public function stringOf(array $replaces = []): string
    {
        $values = [];

        foreach (array_merge($this->commonReplaces(), $replaces) as $key => $value) {
            $values["[$key]"] = $value;
        }

        return Str::of($this->pattern)->replace(array_keys($values), array_values($values))->__toString();
    }

    private function commonReplaces(): array
    {
        $carbon = now();
        $user = Auth::user();

        return array_filter([
            'JJ' => $carbon->day,
            'DD' => $carbon->day,
            'MM' => $carbon->month,
            'AAAA' => $carbon->year,
            'YYYY' => $carbon->year,
            'USER' => data_get($user, 'id')
        ]);
    }
}
