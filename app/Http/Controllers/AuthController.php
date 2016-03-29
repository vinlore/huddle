<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Sentinel;

use App\Http\Requests\RegisterUserRequest;
use App\Models\Profile;
use App\Models\User;

class AuthController extends Controller
{
    function signup(RegisterUserRequest $request)
    {
        $user = [
            'username' => $request->username,
            'email'    => $request->email,
            'password' => $request->password,
        ];
        $user = Sentinel::registerAndActivate($user);

        $role = Sentinel::findRoleByName('Regular User');
        $role->users()->attach($user);

        $user->permissions = $role->permissions;
        $user->save();

        $profile = [
            'is_owner'    => 1,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'first_name'  => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name'   => $request->last_name,
            'city'        => $request->city,
            'country'     => $request->country,
            'birthdate'   => $request->birthdate,
            'gender'      => $request->gender,
        ];
        $profile = new Profile($profile);
        $profile->user()->associate($user);
        $profile->save();

        return $this->signin($request);
    }

    function signin(Request $request)
    {
        $user = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        $user = Sentinel::stateless($user);

        if (!$user) {
            return response()->error(401, 'Invalid Credentials');
        } else {
            $apiToken = bcrypt($user);
            $user->api_token = $apiToken;
            $user->save();

            return response()->json([
                'status'      => 200,
                'message'     => 'OK',
                'token'       => $apiToken,
                'user_id'     => $user->id,
                'permissions' => $user->permissions,
            ]);
        }
    }

    function signout(Request $request)
    {
        $apiToken = $request->header('X-Auth-Token');
        $user = User::where('api_token', $apiToken)->first();

        if (!$user) {
            return response()->error(401, 'Invalid Token Error');
        } else {
            $user->api_token = NULL;
            $user->save();
            return response()->success();
        }
    }

    function confirm(Request $request)
    {
        $apiToken = $request->header('X-Auth-Token');
        $user = User::where('api_token', $apiToken)->first();

        if (!$user) {
            return response()->error(401, 'Invalid Token Error');
        } else {
            return response()->json([
                'status'      => 200,
                'message'     => 'OK',
                'permissions' => $user->permissions,
            ]);
        }
    }
}
