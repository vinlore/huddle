<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Models\Conference;

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
            Profile::create($request->all());
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

    public function test()
    {
        var_dump($lol);
    }
    public function profileConferenceRooms($pid) {
        return \DB::table('profiles')
        ->where('profiles.id', $pid)
        ->join('profile_attends_conferences', 'profile_attends_conferences.profile_id', '=', 'profiles.id')
        ->join('conferences','conferences.id','=','profile_attends_conferences.conference_id')
        ->join('conference_accommodations','conferences.id','=','conference_accommodations.conference_id')
        ->join('rooms', 'conference_accommodations.accommodation_id','=','rooms.accommodation_id')
        ->join('profile_stays_in_rooms','profile_stays_in_rooms.room_id', '=', 'rooms.id')
        ->get(['room_no', 'profiles.id', 'conferences.id']);
    }

    public function profileConferenceVehicles($pid) {
        return \DB::table('profiles')
        ->where('profiles.id', $pid)
        ->join('profile_attends_conferences', 'profile_attends_conferences.profile_id', '=', 'profiles.id')
        ->join('conferences','conferences.id','=','profile_attends_conferences.conference_id')
        ->join('conference_vehicles','conferences.id','=','conference_vehicles.conference_id')
        ->join('vehicles', 'conference_vehicles.vehicle_id','=','vehicles.id')
        ->join('profile_rides_vehicles','profile_rides_vehicles.vehicle_id', '=', 'vehicles.id')
        ->get(['vehicles.name','conferences.id']);
    }

    public function profileEventVehicles($pid) {
        return \DB::table('profiles')
        ->where('profiles.id', $pid)
        ->join('profile_attends_events', 'profile_attends_events.profile_id', '=', 'profiles.id')
        ->join('events','events.id','=','profile_attends_events.event_id')
        ->join('event_vehicles','events.id','=','event_vehicles.event_id')
        ->join('vehicles', 'event_vehicles.vehicle_id','=','vehicles.id')
        ->join('profile_rides_vehicles','profile_rides_vehicles.vehicle_id', '=', 'vehicles.id')
        ->get(['vehicles.name','events.id']);
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
