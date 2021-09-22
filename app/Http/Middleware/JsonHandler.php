<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JsonHandler
{
    /**
     * Accept JSON only
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $header = $request->header('content-type');
        if ($header != 'application/json') {
            return response(['message' => 'Only JSON requests are allowed','success'=>0,'data'=>null], 201);
        }
        if(!$request->isMethod('post')) return $next($request);
        $header = $request->header('Content-type');
        if (!Str::contains($header, 'application/json')) {
            return response(['message' => 'Only JSON requests are allowed','success'=>0,'data'=>null], 201);
        }
        return $next($request);
    }
}
