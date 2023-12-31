<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Guest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth('docter')->check() && auth('docter')->user()->hasRole('docter')) {
            return redirect()->route('home');
        } elseif (auth('web')->check() && auth('web')->user()->hasRole('admin')) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
