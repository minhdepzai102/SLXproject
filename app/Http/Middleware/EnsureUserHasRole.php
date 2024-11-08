<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // Check if user is logged in and has the correct role
        if (!Auth::check() || Auth::user()->role != $role) {
            return redirect()->route('user')->with('error', 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }
}
