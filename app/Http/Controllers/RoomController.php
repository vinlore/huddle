<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Models\Room as Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $room = Room::all();
            //Check if Rooms exists
            if (!$room) {
                return response()->success("Racoon" , "No Rooms Found");
            }
            return $room;
        } catch (Exception $e) {
                return response()->error("Rattle Snake" , $e);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Room::create($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error("Raven" , $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $room = Room::find($id);
            //Check if the Room exists
            if(!$room) {
                response()->success("Rhino" , "Room could not be found.");
            }
            return $room;
        } catch (Exception $e) {
            return response()->error("Ringtail" , $e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $newRoomData = array(
                'accomodation_id' => $request->accomodation_id,
                'room_no' => $request->room_no,
                'guest_count' => $request->guest_count,
                'capacity' => $request->capacity
            );
            Room::where('id', $id)->update($newRoomData);
            return response()->success();
        } catch (Exception $e) {
            return response()->error("Roadrunner" , $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Soft Delete
    }
}
