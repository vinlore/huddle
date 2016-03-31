<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Models\Conference;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(ProfileRequest $request, $uid)
    {
        try {
            return Profile::where('user_id', $uid)->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function store(ProfileRequest $request, $uid)
    {
        try {

            // Check if the User exists.
            $user = User::find($uid);
            if (!$user) {
                return response()->error(404, 'User Not Found');
            }

            // Create the Profile.
            $profile = new Profile($request->all());
            $profile->user()->associate($user);
            $profile->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function update(ProfileRequest $request, $uid, $pid)
    {
        try {
            $profile = Profile::find($pid);
            if(!$profile) {
                return response()->error();
            }
            $profile->update($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function destroy(ProfileRequest $request, $uid, $pid)
    {
        try {
            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error("Profile not found");
            }
            if ($profile->is_owner == 1) {
                return response()->error();
            }
            $profile->delete();
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function conferences(ProfileRequest $request, $id)
    {
        try {

            $profile = Profile::find($id);
            if (!$profile) {
                return response()->success("204","Profile not found");
            }
            return $profile->conferences;

        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function events(ProfileRequest $request, $id)
    {
        try {
            $profile = Profile::find($id);
            if (!$profile) {
                return response()->success("204","Profile not found");
            }
            return $profile->events;
        } catch (Exception $e) {
            return response()->error();
        }
    }

}
