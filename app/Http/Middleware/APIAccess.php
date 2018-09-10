<?php

namespace App\Http\Middleware;

use Closure;

class APIAccess
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
        $client_access_key = $request->header('X-Client-Access-Key');
        $client_secret_key = $request->header('X-Client-Secret');
        $platform = $request->header('X-Client-Platform');
        $client_version = $request->header('X-Client-Version');
        // $client_security_token = $request->header('X-Client-Security-Token');
        $client_uid = $request->header('X-Client-UID');
        $client_time = $request->header('X-Client-Time');

        if ($platform!=null && in_array($platform, array_keys(config('wgconf.headers')))) {
            if ($client_access_key != config('wgconf.headers.' . $platform . '.client_access_key')
                || $client_secret_key != config('wgconf.headers.' . $platform . '.client_secret_key')
                || $client_version != config('wgconf.headers.' . $platform . '.client_version')
                || $client_uid == null
                || $client_time == null) {
                return response()->json(['code' => "You are not authenticated", 'title' => "You are not authenticated", 'detail' => "INVALID_HEADERS",], 401);
            }
        }
        return $next($request);
    }
}
