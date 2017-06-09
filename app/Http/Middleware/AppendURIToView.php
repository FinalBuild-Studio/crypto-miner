<?php

namespace App\Http\Middleware;

use JavaScript;
use Closure;

class AppendURIToView
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
        $url = $request->url();

        JavaScript::put(compact('url'));

        return $next($request);
    }
}
