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
            $method = $request->method();
            // Log only modifications to avoid flooding with GET requests
            if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
                $actionMap = [
                    'POST'   => 'CREATE',
                    'PUT'    => 'UPDATE',
                    'PATCH'  => 'UPDATE',
                    'DELETE' => 'DELETE',
                ];

                Audit::create([
                    'user_id'    => Auth::id(),
                    'action'     => $actionMap[$method] ?? $method,
                    'table_name' => $request->segment(2) ?? 'system', // segment(2) is usually the module name in this app
                    'record_id'  => $this->getRecordId($request),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'new_values' => $request->except(['_token', '_method', 'password', 'password_confirmation', 'fichier'])
                ]);
            }
        }

        return $response;
    }

    protected function getRecordId($request)
    {
        foreach ($request->segments() as $segment) {
            if (is_numeric($segment)) return $segment;
        }
        return null;
    }
}
