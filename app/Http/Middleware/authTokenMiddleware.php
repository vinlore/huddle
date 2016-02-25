<?php

namespace App\Http\Middleware;

use Closure;

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
            var_dump($payload);

        	$user =  \DB::table('users')->where('api_token',$payload)->first();//$userModel->where('api_token',$payload)->first();

        		 if(!$payload || !$user) {

        			 $response = \Response::json([
        				 'error' => true,
        				 'message' => 'Not authenticated',
        				 'code' => 401],
        				 401
        			 );

                    return $response;
                 }
                 //$response->header('Content-Type', 'application/json');
                  return $next($request);

    }
}
