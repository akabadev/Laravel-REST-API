<?php

namespace App\Contracts\Application;

use App\Utils\LogiwebPathResolver;
use Illuminate\Support\Facades\File;

abstract class Application
{
    /**
     * @param string $path
     * @param string|null $key
     * @param bool $associative
     * @return mixed
     */
    public function configuration(string $path, string $key = null, bool $associative = true): mixed
    {
        $clientPath = LogiwebPathResolver::resolveClientConfiguration($path);
        $basePath = LogiwebPathResolver::resolveClientConfiguration($path, true);

        $baseConfig = file_exists($basePath) ? json_decode(File::get($basePath), $associative) : [];
        $clientConfig = file_exists($clientPath) ? json_decode(File::get($clientPath), $associative) : [];

        return data_get(array_merge($baseConfig, $clientConfig), $key);
    }
}
