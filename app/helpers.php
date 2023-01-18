<?php

use App\Contracts\Application\Application as ClientApplication;
use App\Contracts\Application\Setting;
use App\Utils\LogiwebPathResolver;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

if (!function_exists('tenants_path')) {
    /**
     * @return string
     */
    function tenants_path(): string
    {
        return LogiwebPathResolver::resolveClientBasePath();
    }
}

if (!function_exists('client_path')) {
    /**
     * @param string $path
     * @param bool $default
     * @return string
     */
    function client_path(string $path = '', bool $default = false): string
    {
        return LogiwebPathResolver::resolveClientPath($path, $default);
    }
}

if (!function_exists('client_storage')) {
    /**
     * @param string $path
     * @param bool $default
     * @return string
     */
    function client_storage(string $path = '', bool $default = false): string
    {
        return LogiwebPathResolver::resolveClientStorage($path, $default);
    }
}

if (!function_exists('client_resource')) {
    /**
     * @param string $path
     * @return string
     */
    function client_resource(string $path = ""): string
    {
        return LogiwebPathResolver::resolveClientResource($path);
    }
}

if (!function_exists('client_config')) {
    /**
     * @param string $path
     * @param string|null $key
     * @param bool $associative
     * @return mixed
     */
    function client_config(string $path, string $key = null, bool $associative = true): mixed
    {
        return client_app()->configuration($path, $key, $associative);
    }
}

if (!function_exists('client_view')) {
    /**
     * @param string $path
     * @param array $data
     * @param array $mergeData
     * @param string $suffix
     * @return Application|Factory|View
     */
    function client_view(string $path = '', array $data = [], array $mergeData = [], string $suffix = '.blade.php'): View|Factory|Application
    {
        return LogiwebPathResolver::resolveClientView($path, $data, $mergeData, $suffix);
    }
}


if (!function_exists('template_path')) {
    /**
     * @param string|null $name
     * @param string $default
     * @return string
     */
    function template_path(?string $name = '', string $default = 'basic'): string
    {
        $base = storage_path('templates');

        $path = $base . ($name ? DIRECTORY_SEPARATOR . $name : $name);

        return is_dir($path) ? $path : $base . DIRECTORY_SEPARATOR . $default;
    }
}


if (!function_exists('normalize_path')) {
    /**
     * @param string $path
     * @return string
     */
    function normalize_path(string $path = ''): string
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $path);
    }
}

if (!function_exists('client_app')) {
    /**
     * @return ClientApplication
     */
    function client_app(): ClientApplication
    {
        return app(ClientApplication::class);
    }
}

if (!function_exists('setting')) {
    /**
     * @return Setting
     */
    function setting(): Setting
    {
        return app(Setting::class);
    }
}

if (!function_exists('param')) {
    /**
     * @param string|null $key
     * @param mixed|null $default
     * @return Setting
     */
    function param(?string $key = null, mixed $default = null): mixed
    {
        return setting()->valueOf($key, $default);
    }
}

if (!function_exists('on_param')) {
    /**
     * @param string $key
     * @param Closure $success
     * @param Closure|null $failure
     * @param Closure|null $predicate
     * @return Setting
     */
    function on_param(string $key, mixed $success, mixed $failure = null, Closure $predicate = null): mixed
    {
        $predicate = $predicate ?: fn ($value) => !!$value;

        return $predicate($value = param($key)) ?
            ($success instanceof Closure ? $success($value) : $success) :
            ($failure instanceof Closure ? $failure($value) : $failure);
    }
}
