<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\VehicleRequest;

use App\Models\Event;
use App\Models\EventVehicle;

class EventVehicleController extends Controller
{
    /**
     * Retrieve all Vehicles of an Event.
     *
     * @param  Request  $request
     * @param  int  $eid
     * @return Collection|Response
     */
    public function index(Request $request, $eid)
    {
        try {
            $event = Event::find($cid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            return $event->vehicles()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create a Vehicle for an Event.
     *
     * @param  VehicleRequest  $request
     * @param  int  $eid
     * @return Response
     */
    public function store(VehicleRequest $request, $eid)
    {
        try {
            $user = $this->isEventManager($request, $cid);
            if (!$user) {
                return response()->error(403);
            }

            $event = Event::find($cid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            $vehicle = new EventVehicle($request->all());
            $vehicle->event()->associate($event);
            $vehicle->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve a Vehicle of an Event.
     *
     * @param  VehicleRequest  $request
     * @param  int  $eid
     * @param  int  $vid
     * @return App\Models\EventVehicle|Response
     */
    public function show(VehicleRequest $request, $eid, $vid)
    {
        try {
            $event = Event::find($cid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            $vehicle = EventVehicle::find($vid);
            if (!$vehicle) {
                return response()->error(404, 'Vehicle Not Found');
            }

            return $vehicle;
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update a Vehicle of an Event.
     *
     * @param  VehicleRequest  $request
     * @param  int  $eid
     * @param  int  $vid
     * @return Response
     */
    public function update(VehicleRequest $request, $eid, $vid)
    {
        try {
            $user = $this->isEventManager($request, $cid);
            if (!$user) {
                return response()->error(403);
            }

            $event = Event::find($cid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            $vehicle = EventVehicle::find($vid);
            if (!$vehicle) {
                return response()->error(404, 'Vehicle Not Found');
            }

            $vehicle->fill($request->all());
            $vehicle->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete a Vehicle of an Event.
     *
     * @param  VehicleRequest  $request
     * @param  int  $eid
     * @param  int  $vid
     * @return Response
     */
    public function destroy(VehicleRequest $request, $eid, $vid)
    {
        try {
            $user = $this->isEventManager($request, $cid);
            if (!$user) {
                return response()->error(403);
            }

            $event = Event::find($cid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            $vehicle = EventVehicle::find($vid);
            if (!$vehicle) {
                return response()->error(404, 'Vehicle Not Found');
            }

            $vehicle->delete();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
