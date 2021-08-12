<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\AuthController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogConduitRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $start_time = microtime(true);
        try{

        $var = $next($request);
        }
        catch (\Exception $e) {
            $var = [
                'success' => false,
                'char' => ['id' => $request->user()->CHAR_ID ?? null, 'name' => $request->user()->NAME ?? null],
                'error' => get_class($e).': '.$e->getMessage()
            ];
        }
        DB::table('conduit_log')->insert([
            'char_id' => AuthController::getLoginId(),
            'endpoint' => $request->getPathInfo(),
            'requested_at' => now(),
            'execution_time' => round((microtime(true)-$start_time)*1000, 2),
        ]);

        return $var;
    }
}
