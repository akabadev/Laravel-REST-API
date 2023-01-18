<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AllowAccessOnlyFromCentralDomain
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        abort_if(
            null != tenant(),
            Response::HTTP_BAD_REQUEST,
            "Access not allowed from tenants apps"
        );

        return $next($request);
    }
}
