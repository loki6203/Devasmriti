<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                $resp = array('success'=>0,'message'=>'Token is Invalid');
                return response()->json($resp,202);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                $resp = array('success'=>0,'message'=>'Token is Expired');
                return response()->json($resp,202);
            }else{
                $resp = array('success'=>0,'message'=>'Authorization Token not found');
                return response()->json($resp,202);
            }
        }
        return $next($request);
    }
}