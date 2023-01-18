<?php

namespace App\Models\Concerns;

trait HasCode
{
    /**
     * @param string|int $identifier
     * @param bool $fail
     * @return static|null
     */
    public static function find(string|int $identifier, bool $fail = false): ?static
    {
        $query = static::query()->where('id', $identifier)->orWhere('code', $identifier);
        return $fail ? $query->firstOrFail() : $query->first();
    }

    /**
     * @return string
     */
    public static function freshCode(): string
    {
        while (self::find($code = strtoupper(md5(microtime()))) !== null) ;
        return $code;
    }
}
