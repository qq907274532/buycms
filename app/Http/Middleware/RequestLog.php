<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RequestLog
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
        if (config('logging.channels.requestlog.enable') === false) {
            return $next($request);
        }

        //{ip} - {user} - {method} - {url} - {ua} - {context}
        $format = '%s - %s - %s - "%s" - "%s" - "%s"';

        $str = sprintf(
            $format,
            $request->ip(),
            Auth::user() ? Auth::user()->realname : 'guest',
            $request->method(),
            str_replace($request->root(), '', $request->fullUrl()),
            $request->userAgent(),
            json_encode($request->except(config('admin.log.ignore_fields')))
        );

        Log::channel('requestLog')->info($str);

        return $next($request);
    }
}
