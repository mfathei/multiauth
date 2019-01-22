<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $redirect = 'home';
        switch ($guard) {
            case 'admin':
                $redirect = 'admin.dashboard';
                break;
            default:
                $redirect = 'home';
                break;
        }

        if (Auth::guard($guard)->check()) {
            return redirect()->route($redirect);
        }

        return $next($request);
    }
}
