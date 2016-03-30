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
    /**
     * Register a new Regular User and create its owner Profile.
     *
     * @return Response
     */
    function signup(RegisterUserRequest $request)
    {
        // Register the User.
        $user = [
            'username' => $request->username,
            'email'    => $request->email,
            'password' => $request->password,
        ];
        $user = Sentinel::registerAndActivate($user);

        // Give the user the Regular User role.
        $role = Sentinel::findRoleByName('Regular User');
        $role->users()->attach($user);

        $user->permissions = $role->permissions;
        $user->save();

        // Create the owner Profile.
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

        // Automatically sign in after successful registration.
        return $this->signin($request);
    }

    /**
     * Sign a User in.
     *
     * @return Response
     */
    function signin(Request $request)
    {
        // Authenticate the User.
        $user = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        $user = Sentinel::stateless($user);

        // Create an API token for the User.
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
                'profile_id'  => $user->profiles()->where('is_owner', 1)->first()->id,
                'manages_conf'=> $user->conferences()->lists('conference_id'),
                'manages_event' => $user->events()->lists('event_id')
            ]);
        }
    }

    /**
     * Sign a User out.
     *
     * @return Response
     */
    function signout(Request $request)
    {
        // Check if the API token in the request matches the API token in the database.
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

    /**
     * Confirm the login state of a User.
     *
     * @return Response
     */
    function confirm(Request $request)
    {
        // Check if the API token in the request matches the API token in the database.
        $apiToken = $request->header('X-Auth-Token');
        $user = User::where('api_token', $apiToken)->first();

        if (!$user) {
            return response()->error(401, 'Invalid Token Error');
        } else {
            return response()->json([
                'status'      => 200,
                'message'     => 'OK',
                'permissions' => $user->permissions,
                'profile_id'  => $user->profiles()->where('is_owner', 1)->first()->id,
                'manages_conf'=> $user->conferences()->lists('conference_id'),
                'manages_event' => $user->events()->lists('event_id')
            ]);
        }
    }
}
