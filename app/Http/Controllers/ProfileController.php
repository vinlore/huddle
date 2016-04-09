<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\ProfileRequest;

use App\Models\Profile;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Retrieve all Profiles of a User.
     *
     * @param  ProfileRequest  $request
     * @param  int  $uid
     * @return Collection|Response
     */
    public function index(ProfileRequest $request, $uid)
    {
        try {
            $user = User::find($uid);
            if (!$user) {
                return response()->error(404, 'User Not Found');
            }

            return $user->profiles()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create a Profile for a User.
     *
     * @param  ProfileRequest  $request
     * @param  int  $uid
     * @return Response
     */
    public function store(ProfileRequest $request, $uid)
    {
        try {
            $user = User::find($uid);
            if (!$user) {
                return response()->error(404, 'User Not Found');
            }

            $profile = new Profile($request->all());
            $profile->user()->associate($user);
            $profile->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update a Profile of a User.
     *
     * @param  ProfileRequest  $request
     * @param  int  $uid
     * @param  int  $pid
     * @return Response
     */
    public function update(ProfileRequest $request, $uid, $pid)
    {
        try {
            $user = User::find($uid);
            if (!$user) {
                return response()->error(404, 'User Not Found');
            }

            $profile = Profile::find($pid);
            if(!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            $profile->fill($request->all());
            $profile->save();

            if ($profile->is_owner && $request->exists('email')) {
                $user->email = $request->email;
                $user->save();
            }

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete a Profile of a User.
     *
     * @param  ProfileRequest  $request
     * @param  int  $uid
     * @param  int  $pid
     * @return Response
     */
    public function destroy(ProfileRequest $request, $uid, $pid)
    {
        try {
            $user = User::find($uid);
            if (!$user) {
                return response()->error(404, 'User Not Found');
            }

            $profile = Profile::find($pid);
            if(!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            if ($profile->is_owner) {
                return response()->error(403, 'Main profile cannot be deleted!');
            }

            $profile->delete();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve all Conferences a Profile attends.
     *
     * @param  ProfileRequest  $request
     * @param  int  $pid
     * @return Collection|Response
     */
    public function conferences(ProfileRequest $request, $pid)
    {
        try {
            $profile = Profile::find($pid);
            if(!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            return $profile->conferences()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve all Events a Profile attends.
     *
     * @param  ProfileRequest  $request
     * @param  int  $pid
     * @return Collection|Response
     */
    public function events(ProfileRequest $request, $pid)
    {
        try {
            $profile = Profile::find($pid);
            if(!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            return $profile->events()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve all Rooms a Profile stays in.
     *
     * @param  ProfileRequest  $request
     * @param  int  $pid
     * @return Collection|Response
     */
    public function rooms(ProfileRequest $request, $pid)
    {
        try {
            $profile = Profile::find($pid);
            if(!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            $rooms = $profile->rooms()->get();
            foreach ($rooms as $room) {
                $room->setAttribute('conference_id', $room->conference->getKey());
                $room->setAttribute('accommodation_name', $room->accommodation->name);
            }

            return $rooms->makeVisible('conference_id', 'accommodation_name');
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve all Conference Vehicles a Profile rides in.
     *
     * @param  ProfileRequest  $request
     * @param  int  $pid
     * @return Collection|Response
     */
    public function conferenceVehicles(ProfileRequest $request, $pid)
    {
        try {
            $profile = Profile::find($pid);
            if(!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            return $profile->conferenceVehicles()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve all Event Vehicles a Profile rides in.
     *
     * @param  ProfileRequest  $request
     * @param  int  $pid
     * @return Collection|Response
     */
    public function eventVehicles(ProfileRequest $request, $pid)
    {
        try {
            $profile = Profile::find($pid);
            if(!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            return $profile->eventVehicles()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
