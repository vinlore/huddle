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
    public function show($id){
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        try {
            //Update Profile Riding on different Vehicle
            Profile::find($request->profile_id)
                    ->vehicles()
                    ->updateExistingPivot($request->old_vehicle_id, ['vehicle_id' => $request->new_vehicle_id]);
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
    public function destroy(Request $request) {
        try {
            //Removing the link between ONE Profile <-> Vehicle
            $vehicle = Vehicle::find($request->vehicle_id);
            Profile::find($request->profile_id)
                    ->vehicles()
                    ->detach($vehicles);

            return response()->success();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }
}
