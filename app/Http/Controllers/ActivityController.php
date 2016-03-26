<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;

use Redis;

use App\Models\Activity as Activity;
use App\Models\User as User;


class ActivityController extends Controller
{

	function get(Request $request){
        try {
        	$user_id = $request->header('ID');
        	$api_token = $request->header('X-Auth-Token');
        	$user_to_check = User::find($user_id);

        	if($user_to_check->api_token == $api_token){

        		$activities = Activity::all();
            	if (!$activities) {
                	return response()->error("No acitivities found.");
            	}
            	return $activities;
        	}else{
        		return response()->error("No access.");
        	}
        } catch (Exception $e) {
            return response()->error("500" , $e);
        }
	}

}