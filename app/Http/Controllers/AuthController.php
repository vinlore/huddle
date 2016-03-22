<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Sentinel;

use App\Models\Profile;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Registers a new Regular User and creates its owner profile.
     */
    function register(Request $request)
    {
        $user = [
            'username' => $request->username,
            'email'    => $request->email,
            'password' => $request->password,
        ];

        $user = Sentinel::registerAndActivate($user);

        // TODO: Change request fields to snake_case
        $profile = [
            'is_owner'    => 1,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'first_name'  => $request->firstName,
            'middle_name' => $request->middleName,
            'last_name'   => $request->lastName,
            'city'        => $request->city,
            'country'     => $request->country,
            'birthdate'   => $request->birthdate,
            'gender'      => $request->gender,
        ];

        $profile = new Profile($profile);
        $profile->user()->associate($user);
        $profile->save();

        $role = Sentinel::findRoleByName('Regular User');
        $role->users()->attach($user);

        return $this->login($request);
    }

    /**
     * Logs a user in.
     */
    function login(Request $request)
    {
        $user = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $user = Sentinel::stateless($user);

        if (!$user) {
            return response()->error('USER_NOT_FOUND', 'Incorrect username or password.');
        }

        $token = bcrypt($user);
        $user->api_token = $token;
        $user->save();

        return response()->json([
            'status'  => 'success',
            'token'   => $token,
            'user_id' => $user->id,
        ]);
    }

    /**
     * Logs a user out.
     */
    function logout(Request $request)
    {
        $token = $request->header('X-Auth-Token');
        $user = User::where('api_token', $token)->first();

        if ($user) {
            $user->api_token = NULL;
            $user->save();
            return response()->success();
        } else {
            return response()->error('TOKEN_NOT_FOUND', 'Token not found.');
        }
    }


    /**
     * Confirms that a user is logged in.
     */
    function confirm(Request $request)
    {
        $token = $request->header('X-Auth-Token');
        $user = User::where('api_token', $token)->first();

        if ($user) {
            return response()->success();
        } else {
            return response()->error('TOKEN_NOT_FOUND', 'Token not found.');
        }
    }
}
