<?php

namespace App\Http\Middleware;

use App\Exceptions\ConduitSecurityViolationException;
use App\Exceptions\SecurityViolationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Str;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return string|null
     * @throws SecurityViolationException
     */
    protected function redirectTo($request)
    {
        $middlewares = collect($request->route()
                                      ->gatherMiddleware());
        if ($middlewares->contains('api') && $middlewares->contains('auth:sanctum')) {
            throw new ConduitSecurityViolationException("Please provide a valid authentication bearer token.");
        }


        if (! $request->expectsJson()) {
            return route('auth-start');
        }
    }


}
