<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;


class EnsureProfileIsComplete
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->is_profile_complete) {
            return redirect()->route('complete-profile');
        }

        return $next($request);
    }
}
