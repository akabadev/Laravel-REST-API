<?php

namespace App\Logging;

class TaskLogger extends CustomFileLogger
{
    const name = 'tasks-logger';

    /**
     * @return string
     */
    protected function getFullPath(): string
    {
        $tenant = tenant();
        $prefix = $tenant ? "tenants/$tenant->id/" : '';
        $path = "";

        tenancy()->central(function () use (&$prefix, &$path) {
            $path = storage_path($prefix . 'logs/tasks-' . now()->toDateString() . '.log');
        });

        return $path;
    }
}
