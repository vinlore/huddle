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
    public function index($user)
    {
        try {
            return Profile::where('user_id', $user)->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function store(ProfileRequest $request, $id)
    {
        try {
            $request->is_owner = 0;
            User::find($id)->profiles()->create($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function update(ProfileRequest $request, $id)
    {
        try {
            Profile::findOrFail($id)->update($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function allProfileConferences($id)
    {
      try {
        $conferenceProfiles = [];

    $profile = Profile::findOrFail($id);
    foreach ($profile->conferences as $conference) {
        $conferenceProfiles[] = $conference;
    }

    return $conferenceProfiles;

    } catch (Exception $e) {
        return response()->error();
    }

  }

    public function destroy($users, $profiles)
    {
        try {
            $profile = Profile::findOrFail($profiles);
            if ($profile->is_owner == 1) {
                return response()->error();
            }
            $profile->delete();
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function conferences($id)
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

    public function events($id)
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
