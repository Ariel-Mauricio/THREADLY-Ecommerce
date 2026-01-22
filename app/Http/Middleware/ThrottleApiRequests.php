<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ThrottleApiRequests
{
    /**
     * Handle an incoming request.
     * Rate limits API requests to prevent abuse.
     */
    public function handle(Request $request, Closure $next, string $key = 'api', int $maxAttempts = 60, int $decayMinutes = 1): Response
    {
        $identifier = $this->resolveRequestIdentifier($request, $key);

        if (RateLimiter::tooManyAttempts($identifier, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($identifier);
            
            return response()->json([
                'success' => false,
                'message' => 'Demasiadas solicitudes. Por favor espera ' . $seconds . ' segundos.',
                'retry_after' => $seconds,
            ], 429)->withHeaders([
                'Retry-After' => $seconds,
                'X-RateLimit-Limit' => $maxAttempts,
                'X-RateLimit-Remaining' => 0,
            ]);
        }

        RateLimiter::hit($identifier, $decayMinutes * 60);

        $response = $next($request);

        return $response->withHeaders([
            'X-RateLimit-Limit' => $maxAttempts,
            'X-RateLimit-Remaining' => RateLimiter::remaining($identifier, $maxAttempts),
        ]);
    }

    /**
     * Resolve the request identifier for rate limiting.
     */
    protected function resolveRequestIdentifier(Request $request, string $key): string
    {
        // Use user ID if authenticated, otherwise use IP
        if ($request->user()) {
            return $key . ':user:' . $request->user()->id;
        }

        return $key . ':ip:' . $request->ip();
    }
}
