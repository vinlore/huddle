<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Log;
use Sentinel;

use App\Http\Requests\RegisterUserRequest;

use App\Models\Profile;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Register a new Regular User and create its owner Profile.
     *
     * @param  RegisterUserRequest  $request
     * @return Response
     */
    function signup(RegisterUserRequest $request)
    {
        try {
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

            Log::info('[User] ' . $request->ip() . ' registered User ' . $user->id);

            return $this->signin($request);
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Sign a User in.
     *
     * @param  Request  $request
     * @return Response
     */
    function signin(Request $request)
    {
        try {
            $user = [
                'username' => $request->username,
                'password' => $request->password,
            ];

            $user = Sentinel::stateless($user);
            if (!$user) {
                return response()->error(401, 'Invalid Credentials');
            }

            $apiToken = bcrypt($user);
            $user->api_token = $apiToken;
            $user->save();

            Log::info('[User] ' . $request->ip() . ' signed into User ' . $user->id);

            return response()->json([
                'status'        => 200,
                'message'       => 'OK',
                'token'         => $apiToken,
                'user_id'       => $user->id,
                'permissions'   => $user->permissions,
                'profile_id'    => $user->profiles()->where('is_owner', 1)->first()->id,
                'manages_conf'  => $user->conferences()->lists('conference_id'),
                'manages_event' => $user->events()->lists('event_id'),
            ]);
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Sign a User out.
     *
     * @param  Request  $request
     * @return Response
     */
    function signout(Request $request)
    {
        try {
            $user = $this->getUser($request);
            if (!$user) {
                return response()->error(401, 'Invalid Token Error');
            }

            $user->api_token = NULL;
            $user->save();

            Log::info('[User] ' . $request->ip() . ' signed out of User ' . $user->id);

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Confirm the login state of a User.
     *
     * @param  Request  $request
     * @return Response
     */
    function confirm(Request $request)
    {
        try {
            $user = $this->getUser($request);
            if (!$user) {
                return response()->error(401, 'Invalid Token Error');
            }

            return response()->json([
                'status'        => 200,
                'message'       => 'OK',
                'permissions'   => $user->permissions,
                'profile_id'    => $user->profiles()->where('is_owner', 1)->first()->id,
                'manages_conf'  => $user->conferences()->lists('conference_id'),
                'manages_event' => $user->events()->lists('event_id'),
            ]);
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
