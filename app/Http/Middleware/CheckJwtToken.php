<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

use Exception;

class CheckJwtToken
{
    public function handle($request, Closure $next)
    {
        // Periksa jika route adalah login atau register
        if ($request->is('api/auth/login') || $request->is('api/register')|| $request->is('api/beritas') || $request->is('api/beritas/*') ) {
            return $next($request);
        }
    
    
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
