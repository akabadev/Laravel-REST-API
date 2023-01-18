<?php

namespace App\Logging;

class SqlQueryLogger extends CustomFileLogger
{
    const name = 'log-sql-queries';

    /**
     * @return string
     */
    protected function getFullPath(): string
    {
        $tenant = tenant();
        $prefix = $tenant ? "tenants/$tenant->id/" : "";

        tenancy()->central(function () use (&$prefix, &$path) {
            $path = storage_path($prefix . 'logs/sql-' . now()->toDateString() . '.log');
        });

        return $path;
    }
}
