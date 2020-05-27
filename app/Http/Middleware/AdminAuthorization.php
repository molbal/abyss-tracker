<?php

namespace App\Http\Middleware;

use Closure;
use http\Exception\RuntimeException;

class AdminAuthorization
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
//        dd(session()->all());
        if (session()->get("login_id") != env("ADMIN_USER_ID", "")) {
            throw new \RuntimeException("Your user id is ".session()->get("login_id", 0)." and it has to be ".env("ADMIN_USER_ID", 0)." to access the logs.", 403);
////            return redirect(view("403",["Error" => "nope"]));
        }

        return $next($request);
    }
}
