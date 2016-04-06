<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Profile;
use App\Models\Vehicle;

class VehiclePassengerController extends Controller
{
    /**
     * Retrieve all Passengers of a Vehicle.
     *
     * @return Collection|Response
     */
    public function index($id){
        //Show all the passengers within this one id.
        try{
            $vehicle = Vehicle::find($id)->passengers()->get();
            if(!$vehicle){
                return response()->success("204", "No Passengers found.");
            }
            return $vehicle;
        } catch (Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Create a Passenger for a Vehicle.
     *
     * @return Response
     */
    public function store(Request $request, $vid) {
        try {
            Profile::find($request->profile_id)
                    ->vehicles()
                    ->attach($vid);

            $passenger_count = Vehicle::find($vid)->passengers()->count();
            Vehicle::where('id',$vid)->update(['passenger_count' => $passenger_count]);
            return response()->success();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Delete a Passenger of a Vehicle.
     *
     * @return Response
     */
    public function destroy($vid, $pid) {
        try {
            //Removing the link between ONE Profile <-> Vehicle
            Profile::find($pid)
                    ->vehicles()
                    ->detach($vid);
            $vehicle = Vehicle::find($vid);
            $vehicle->decrement('passenger_count');

            return response()->success();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }
}
