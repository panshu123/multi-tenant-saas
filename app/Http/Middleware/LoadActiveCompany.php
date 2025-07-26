<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoadActiveCompany
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            Auth::user()->load('activeCompany');
        }

        return $next($request);
    }
}
