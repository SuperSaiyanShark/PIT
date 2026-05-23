<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MeadowStaffOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user email ends with @meadow.com
        if (!str_ends_with(auth()->user()->email, '@meadow.com')) {
            abort(403, 'Only @meadow.com staff accounts can access staff management.');
        }

        return $next($request);
    }
}
