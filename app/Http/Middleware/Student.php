<?php

namespace Portal\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class Student
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        } else if (!Auth::guard($guard)->user()->active) {
            return redirect()->to('/')->withError('Permission Denied');
        }

        return $next($request);
    }
}
