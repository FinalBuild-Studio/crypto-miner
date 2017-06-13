<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;

class DevelopmentMode
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
        if (env('APP_ENV') !== 'production') {
            $user = $request->user();

            if (!$user) {
                Auth::login(User::first());
            }
        }

        return $next($request);
    }
}
