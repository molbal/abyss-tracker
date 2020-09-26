<?php

namespace App\Http\Middleware;

use Closure;

class SSOLoggedIN
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->session()->exists("login_id")) {
            return redirect(route("helper.message.login"));
        }
        return $next($request);
    }
}
