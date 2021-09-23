<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->hasRole('ADMINISTRATOR')) {
            return $next($request);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Access denied.'
            ], 403);
        }
    }
}
