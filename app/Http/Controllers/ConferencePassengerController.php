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

            $passengers = $vehicle->passengers()->get();

            $flightAttrs = [];
            foreach ($passengers as $passenger) {
                $attendee = $passenger->conferences()->where('conference_id', $cid)->first()->pivot;
                if ($attendee->arrv_ride_req) {
                    $passenger->setAttribute('arrv_date', $attendee->arrv_date);
                    $passenger->setAttribute('arrv_time', $attendee->arrv_time);
                    $passenger->setAttribute('arrv_airport', $attendee->arrv_airport);
                    $passenger->setAttribute('arrv_flight', $attendee->arrv_flight);
                    $flightAttrs = array_merge($flightAttrs, ['arrv_date', 'arrv_time', 'arrv_airport', 'arrv_flight']);
                }
                if ($attendee->dept_ride_req) {
                    $passenger->setAttribute('dept_date', $attendee->dept_date);
                    $passenger->setAttribute('dept_time', $attendee->dept_time);
                    $passenger->setAttribute('dept_airport', $attendee->dept_airport);
                    $passenger->setAttribute('dept_flight', $attendee->dept_flight);
                    $flightAttrs = array_merge($flightAttrs, ['dept_date', 'dept_time', 'dept_airport', 'dept_flight']);
                }
            }

            return $passengers->makeVisible($flightAttrs);
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

            if ($vehicle->passenger_count >= $vehicle->capacity) {
                return response()->error(422, 'Exceed Capacity Error');
            }

            $vehicle->passengers()->attach($profile);
            $vehicle->increment('passenger_count');

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
