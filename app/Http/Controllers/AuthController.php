<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Sentinel;

use App\Models\Profile as Profile;
use App\Models\User as User;

class AuthController extends Controller
{
    // TODO: Validate input
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

        return $this->login($request);
    }

    function login(Request $request)
    {
        $user = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $user = Sentinel::stateless($user);

        $token = bcrypt($user);
        $user->api_token = $token;
        $user->save();

        return response()->json([
            'status'  => 'success',
            'token'   => $token,
            'user_id' => $user->id,
        ]);
    }

    function logout(Request $request)
    {
        $user = User::where('api_token', '=', $request->token);

        if ($user) {
            $user->update([
                'api_token' => '',
            ]);
            return response()->success();
        } else {
            return response()->error('TOKEN_NOT_FOUND', 'Token not found.');
        }
    }
}
