<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsDriver
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();


        if (!$user || $user->role !== 'driver') {
            return response()->json([
                'message' => 'Unauthorized - Driver only'
            ], 403);
        }

        return $next($request);
    }
}
