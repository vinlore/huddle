<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\VehicleRequest;

use App\Models\Conference;
use App\Models\ConferenceVehicle;

class ConferenceVehicleController extends Controller
{
    /**
     * Retrieve all Vehicles of a Conference.
     *
     * @param  Request  $request
     * @param  int  $cid
     * @return Collection|Response
     */
    public function index(Request $request, $cid)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            if ($request->exists('type')) {
                return $conference->vehicles()->where('type', $request->type)->get();
            }
            
            return $conference->vehicles()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create a Vehicle for a Conference.
     *
     * @param  VehicleRequest  $request
     * @param  int  $cid
     * @return Response
     */
    public function store(VehicleRequest $request, $cid)
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

            $vehicle = new ConferenceVehicle($request->all());
            $vehicle->conference()->associate($conference);
            $vehicle->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve a Vehicle of a Conference
     *
     * @param  VehicleRequest  $request
     * @param  int  $cid
     * @param  int  $vid
     * @return App\Models\ConferenceVehicle|Response
     */
    public function show(VehicleRequest $request, $cid, $vid)
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

            return $vehicle;
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update a Vehicle of a Conference.
     *
     * @param  VehicleRequest  $request
     * @param  int  $cid
     * @param  int  $vid
     * @return Response
     */
    public function update(VehicleRequest $request, $cid, $vid)
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

            $vehicle->fill($request->all());
            $vehicle->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete a Vehicle of a Conference.
     *
     * @param  VehicleRequest  $request
     * @param  int  $cid
     * @param  int  $vid
     * @return Response
     */
    public function destroy(VehicleRequest $request, $cid, $vid)
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

            $vehicle->delete();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
