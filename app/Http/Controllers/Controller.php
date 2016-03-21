<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function checkPermission($AuthToken,$permissionArray)
    {
        $user_id = User::where('api_token', $permissionArray)->first();
        $user = \Sentinel::findById($user_id->id);

        if (!$user->hasAccess($permissionArray)){
            return \Response::json(array(
                'status' => 'error',
                'code' => 'Role Permissions',
                'message' => 'You have no permissions to access this'
            ));
        }
        else{
            return true;
        }
    }
}
