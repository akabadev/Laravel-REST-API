<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains as Middleware;

class PreventAccessFromCentralDomains extends Middleware
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
            tenant() == null,
            Response::HTTP_BAD_REQUEST,
            'Access not allowed from main app'
        );

        return (config('tenancy.by_domain')) ? parent::handle($request, $next) : $next($request, $next);
    }
}
