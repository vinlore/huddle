<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Requests\ConferenceRequest;

use App\Models\Profile as Profile;
use App\Models\Room as Room;

class RoomGuestController extends Controller
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

    public function store(Request $request, $rid) {
        try {
            Profile::find($request->profile_id)
                    ->rooms()
                    ->attach($rid);

            //Update Room Count
            $room_count = Room::find($rid)->guests()->count();
            Room::where('id',$rid)->update(['guest_count' => $room_count]);

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
    public function update(Request $request, $id){
        try {
            //Update Profile Riding on different Vehicle
            Profile::find($request->profile_id)
                    ->rooms()
                    ->updateExistingPivot($request->old_room_id, ['room_id' => $request->new_room_id]);

            //Update Room Count
            $room_count = Room::find($rid)->guests()->count();
            Room::where('id',$rid)->update(['guest_count' => $room_count]);

            $room_count = Room::find($request->old_room_id)->guests()->count();
            Room::where('id',$request->old_room_id)->update(['guest_count' => $room_count]);
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
    public function destroy($rid, $pid) {
        try {

            Profile::find($pid)
                    ->rooms()
                    ->detach($room);
            $room = Room::find($rid);
            $room->decrement('guest_count');

            return response()->success();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }
}
