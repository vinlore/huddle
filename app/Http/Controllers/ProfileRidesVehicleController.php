<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Requests\ConferenceRequest;

use App\Models\Profile as Profile;
use App\Models\Vehicle as Vehicle;

class ProfileRidesVehicleController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

    public function store(Request $request, $vid) {
        try {
            Profile::find($request->profile_id)
                    ->vehicles()
                    ->attach($vid);
            return response()->success();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vid, $pid){
        try {
            //Update Profile Riding on different Vehicle
            Profile::find($pid)
                    ->vehicles()
                    ->updateExistingPivot($request->old_vehicle_id, ['vehicle_id' => $vid]);
            /*
            *TODO: check if user wants email notifcations. If yes, send one.
            *TODO: ADD notification column to user table.
            */
            return response()->success();
         } catch (Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
