<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ($role === 'admin') {
            $role = 1;
        } elseif ($role === 'controller') {
            $role = 2;
        }
//        dd($request->user()->role);

//        if (!isset($request->user()->role)) {
//            return redirect('/');
//        }
        if( $request->user()->role !== $role) {
            return redirect('/');
        }

        return $next($request);
    }
}
