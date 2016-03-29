<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Models\Conference;

class ProfileController extends Controller
{
    public function index($user)
    {
        try {
            return Profile::where('user_id', $user)->first();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function store(ProfileRequest $request)
    {
        try {
            Profile::create($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function update(ProfileRequest $request, $id)
    {
        try {
            $profile = Profile::find($id);
            if(!$profile) {
                return response()->error();
            }
            $profile->update($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function destroy($id)
    {
        try {
            $profile = Profile::find($id);
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
