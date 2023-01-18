<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class RequiredBearerTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws Throwable
     */
    public function handle(Request $request, Closure $next): mixed
    {
        abort_unless(
            $request->bearerToken(),
            Response::HTTP_UNAUTHORIZED,
            'Bearer token not provided in [Authorization header]'
        );

        return $next($request);
    }
}
