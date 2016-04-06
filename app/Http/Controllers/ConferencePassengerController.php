<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Conference;
use App\Models\ConferenceVehicle;
use App\Models\Profile;

class ConferencePassengerController extends Controller
{
    /**
     * Retrieve all Passengers of a Conference Vehicle.
     *
     * @param  Request  $request
     * @param  int  $cid
     * @param  int  $vid
     * @return Collection|Response
     */
    public function index(Request $request, $cid, $vid)
    {
        try {
            $user = $this->isConferenceManager($request, $cid);
            if (!$user) {
                return response()->error(403);
            }

            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $vehicle = ConferenceVehicle::find($vid);
            if (!$vehicle) {
                return response()->error(404, 'Vehicle Not Found');
            }

            return $vehicle->passengers()->get();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Create a Passenger for a Conference Vehicle.
     *
     * @param  Request  $request
     * @param  int  $cid
     * @param  int  $vid
     * @return Response
     */
    public function store(Request $request, $cid, $vid)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $vehicle = ConferenceVehicle::find($vid);
            if (!$vehicle) {
                return response()->error(404, 'Vehicle Not Found');
            }

            $pid = $request->profile_id;
            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            $vehicle->passengers()->attach($profile);

            return response()->success();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Delete a Passenger of a Conference Vehicle.
     *
     * @param  Request  $request
     * @param  int  $cid
     * @param  int  $vid
     * @param  int  $pid
     * @return Response
     */
    public function destroy(Request $request, $cid, $vid, $pid)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $vehicle = ConferenceVehicle::find($vid);
            if (!$vehicle) {
                return response()->error(404, 'Vehicle Not Found');
            }

            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            $vehicle->passengers()->detach($profile);
            $vehicle->decrement('passenger_count');

            return response()->success();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }
}
