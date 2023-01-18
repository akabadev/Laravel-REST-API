<?php

namespace App\Utils;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

final class LogiwebPathResolver
{
    private const CLIENTS_ROOT_DIRECTORY = "tenants";
    private const DEFAULT_APP_NAME = "Basic";
    private const RESOURCES_DIRECTORY = "resources";
    private const CONFIGURATION_DIRECTORY = "config";
    private const VIEWS_DIRECTORY = "views";
    private const STORAGE_DIRECTORY = "storage";

    private function __construct($app = self::DEFAULT_APP_NAME)
    {
    }

    public static function resolveClientBasePath(): string
    {
        return base_path(self::CLIENTS_ROOT_DIRECTORY);
    }

    /**
     * @param string $path
     * @param bool $defaultFirst
     * @return string
     */
    public static function resolveClientPath(string $path = '', bool $defaultFirst = false): string
    {
        return self::resolveClientBasePath() .
            DIRECTORY_SEPARATOR .
            Str::ucfirst(Str::camel($defaultFirst ? self::DEFAULT_APP_NAME : tenant('id'))) .
            ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param string $path
     * @param bool $defaultFirst
     * @return string
     */
    public static function resolveClientResource(string $path = '', bool $defaultFirst = false): string
    {
        $base = self::resolveClientPath(self::RESOURCES_DIRECTORY, $defaultFirst);
        return $base . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param string $path
     * @param bool $defaultFirst
     * @return string
     */
    public static function resolveClientStorage(string $path = '', bool $defaultFirst = false): string
    {
        $base = self::resolveClientPath(self::STORAGE_DIRECTORY, $defaultFirst);
        return $base . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * @param string $path
     * @param bool $defaultFirst
     * @return string
     */
    public static function resolveClientConfiguration(string $path = '', bool $defaultFirst = false): string
    {
        $base = self::resolveClientPath(self::CONFIGURATION_DIRECTORY, $defaultFirst);
        $base .= ($path ? DIRECTORY_SEPARATOR . $path : $path);

        if (!file_exists($base)) {
            $base = self::resolveClientPath(self::CONFIGURATION_DIRECTORY, true);
            $base .= ($path ? DIRECTORY_SEPARATOR . $path : $path);
        }

        return $base;
    }

    /**
     * @param string $path
     * @param array $data
     * @param array $mergeData
     * @param string $suffix
     * @return \Illuminate\Contracts\View\View
     */
    public static function resolveClientView(string $path = '', array $data = [], array $mergeData = [], string $suffix = '.blade.php'): \Illuminate\Contracts\View\View
    {
        $file = client_resource(self::VIEWS_DIRECTORY . DIRECTORY_SEPARATOR . $path . $suffix);

        if (!file_exists($file)) {
            $file = self::resolveClientBasePath() . DIRECTORY_SEPARATOR .
                self::DEFAULT_APP_NAME . DIRECTORY_SEPARATOR .
                self::RESOURCES_DIRECTORY . DIRECTORY_SEPARATOR .
                self::VIEWS_DIRECTORY . DIRECTORY_SEPARATOR .
                $path . $suffix;
        }

        return View::file($file, $data, $mergeData);
    }
}
