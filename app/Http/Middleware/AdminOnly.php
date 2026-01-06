<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (session('role') !== 'admin') {
            abort(403);
        }
        return $next($request);
    }
}
