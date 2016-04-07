<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Event;
use App\Models\EventVehicle;
use App\Models\Profile;

class EventPassengerController extends Controller
{
    /**
     * Retrieve all Passengers of an Event Vehicle.
     *
     * @param  Request  $request
     * @param  int  $eid
     * @param  int  $vid
     * @return Collection|Response
     */
    public function index(Request $request, $eid, $vid)
    {
        try {
            $user = $this->isEventManager($request, $eid);
            if (!$user) {
                return response()->error(403);
            }

            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            $vehicle = EventVehicle::find($vid);
            if (!$vehicle) {
                return response()->error(404, 'Vehicle Not Found');
            }

            return $vehicle->passengers()->get();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Create a Passenger for an Event Vehicle.
     *
     * @param  Request  $request
     * @param  int  $eid
     * @param  int  $vid
     * @return Response
     */
    public function store(Request $request, $eid, $vid)
    {
        try {
            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            $vehicle = EventVehicle::find($vid);
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
     * Delete a Passenger of an Event Vehicle.
     *
     * @param  Request  $request
     * @param  int  $eid
     * @param  int  $vid
     * @param  int  $pid
     * @return Response
     */
    public function destroy(Request $request, $eid, $vid, $pid)
    {
        try {
            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            $vehicle = EventVehicle::find($vid);
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
