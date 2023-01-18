<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            $parameters = config('tenancy.by_domain') ? [] : ['tenant' => tenant('id')];
            $prefix = Str::startsWith(\request()->path(), "api/v1/") ? "api-1." : "";
            return route($prefix . "web-sign-in-form", $parameters);
        }

        return null;
    }
}
