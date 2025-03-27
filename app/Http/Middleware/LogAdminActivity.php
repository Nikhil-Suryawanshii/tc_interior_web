<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogAdminActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);

         // Log admin actions
         if ($request->is('admin/*')) {
            $logData = [
                'ip_address' => $request->ip(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'user_id' => auth()->guard('admin')->user()->id ?? 'Guest',
                'action_time' => now()->toDateTimeString(), // Adds timestamp
            ];

            Log::channel('daily')->info('Admin Action: ', $logData);
        }

        return $response;


    }
}
