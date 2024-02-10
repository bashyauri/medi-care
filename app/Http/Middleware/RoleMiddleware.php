<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Access authenticated user information (replace with your authentication logic)
        $user = $request->user();

        if (!$user || $user->role !== $role) {
            // Return a structured JSON response with appropriate HTTP status code
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Permission denied for this role'
            ], 403);
        }

        return $next($request);
    }
}