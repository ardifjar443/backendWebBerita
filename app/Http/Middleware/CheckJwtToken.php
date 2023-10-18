<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;

class CheckJwtToken
{
    public function handle($request, Closure $next)
    {
        $token = JWTAuth::parseToken();
    
        if (!$token->check()) {
            return response()->json(['error' => 'Token is invalid'], 401);
        }
        try {
            $user = $token->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired'], 401);
        }
    
        return $next($request);
    }
    
}
