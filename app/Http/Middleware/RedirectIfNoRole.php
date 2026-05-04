<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNoRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // If the user has no roles and is not an admin (bypass if needed)
            // and is not already on the waiting room or logout route
            if ($user->roles->isEmpty() && 
                !$request->routeIs('waiting.room') && 
                !$request->routeIs('logout')) {
                
                return redirect()->route('waiting.room');
            }

            // If the user HAS roles but tries to go to the waiting room, redirect to dashboard
            if (!$user->roles->isEmpty() && $request->routeIs('waiting.room')) {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
