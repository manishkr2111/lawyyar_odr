<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class ApiTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('X-API-TOKEN'); // token sent in header
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'API token missing'], 401);
        }

        // Check token against stored value (cache or config)
        $validToken = Setting::get('api_access_token');

        if (!$validToken || $token !== $validToken) {
            return response()->json(['success' => false, 'message' => 'Invalid API token'], 403);
        }
        return $next($request);
    }
}
