<?php

namespace App\Http\Middleware;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

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
            //var_dump($payload);

        	$user =  \DB::table('users')->where('api_token',$payload)->first();
        		 if(!$payload || !$user) {
                //if(!$user = \Sentinel::check()){
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
