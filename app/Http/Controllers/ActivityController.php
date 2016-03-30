<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Redis;

use App\Models\Activity;
use App\Models\User;

class ActivityController extends Controller
{
    function get(Request $request)
    {
        try {
            $userId = $request->header('ID');
            $apiToken = $request->header('X-Auth-Token');

            $user = User::find($userId);
            if (!$user) {
                return response()->error(404);
            }

            if ($user->api_token == $apiToken) {
                return Activity::all();
            } else {
                return response()->error();
            }
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
