<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Audit;
use Illuminate\Support\Facades\Auth;

class LogActivity
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

                if (Auth::check()) {
                Audit::create([
                'user_id'    => Auth::id(),
                'action'     => 'VISIT',
                'table_name' => 'ROUTE',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        }

        return $response;
    }
}
