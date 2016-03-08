<?php

namespace App\Http\Middleware;

use Closure;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class authTokenMiddleware
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
        $payload = $request->header('X-Auth-Token');
        $user = \DB::table('users')->where('api_token', $payload)->first();

        if(!$payload || !$user) {
            $response = \Response::json([
                'error' => true,
                'message' => 'Not authenticated',
                'code' => 401,
            ], 401);

            return $response;
        }

        return $next($request);
    }
}
