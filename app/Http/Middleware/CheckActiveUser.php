<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckActiveUser
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_active) {

            Auth::logout();

            return redirect('/login')->withErrors([
                'email' => 'Compte désactivé'
            ]);
        }

        return $next($request);
    }
}
