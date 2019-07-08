<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuthMiddleware
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
        return $next($request);
        $token = explode(' ', $request->header('Authorization') ?? '');

        if (\App\Helpers\Auth::getTokenValidity($token[1])) {
            return $next($request);
        }

        return \Response::json([
            'data' => [],
            'message' => 'Not Allowed',
            'status' => 403,
        ]);
    }
}
