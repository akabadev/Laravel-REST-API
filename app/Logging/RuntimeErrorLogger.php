<?php

namespace App\Logging;

use Illuminate\Support\Str;

class RuntimeErrorLogger extends CustomFileLogger
{
    const name = 'tenant-runtime-error';

    /**
     * @return string
     */
    protected function getFullPath(): string
    {
        $tenant = tenancy()->find(Str::beforeLast(request()->path() ?? "", '/api/'));
        $prefix = $tenant ? "tenants/$tenant->id/" : "";

        tenancy()->central(function () use (&$prefix, &$path) {
            $path = storage_path($prefix . 'logs/runtime-' . now()->toDateString() . '.log');
        });

        return $path;
    }
}
