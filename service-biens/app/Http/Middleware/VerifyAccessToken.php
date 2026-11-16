<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class VerifyAccessToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Non authentifiÃ©'], 401);
        }

        $cacheKey = 'api_token:' . hash('sha256', $token);
        $valid = Cache::get($cacheKey);

        if ($valid === null) {
            try {
                $response = Http::timeout(30)
                    ->withToken($token)
                    ->acceptJson()
                    ->get(rtrim((string) env('APP_URL_ADMIN', 'http://service-admin:80'), '/') . '/api/moi');
                $valid = $response->successful();
            } catch (\Throwable $e) {
                $valid = false;
            }

            if ($valid) {
                Cache::put($cacheKey, true, 60);
            }
        }

        if (!$valid) {
            return response()->json(['message' => 'Token invalide ou expirÃ©'], 401);
        }

        return $next($request);
    }
}
