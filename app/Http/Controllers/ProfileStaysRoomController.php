<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Requests\ConferenceRequest;

use App\Models\Profile as Profile;
use App\Models\Rooms as Room;

require app_path().'/helpers.php';

class ProfileStaysRoomController extends Controller
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
            $room = Room::find($id)->guests()->get();
            if(!$room){
                return response()->success("204", "No Guests found.");
            }
            return $room;
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
                    ->rooms()
                    ->updateExistingPivot($request->old_room_id, ['room_id' => $request->new_room_id]);
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
            $room = Room::find($request->room_id);
            Profile::find($request->profile_id)
                    ->rooms()
                    ->detach($room);

            return response()->success();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }
}
