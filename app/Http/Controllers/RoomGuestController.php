<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Profile;
use App\Models\Room;

class RoomGuestController extends Controller
{
    /**
     * Retrieve all Guests of a Room.
     *
     * @return Collection|Response
     */
    public function index($rid)
    {
        try {

            // Check if the Room exists.
            $room = Room::find($rid);
            if (!$room) {
                return response()->error(404, 'Room Not Found');
            }

            // Retrieve its Guests.
            return $room->guests()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create a Guest for a Room.
     *
     * @return Response
     */
    public function store(Request $request, $rid)
    {
        try {

            // Check if the Room exists.
            $room = Room::find($rid);
            if (!$room) {
                return response()->error(404, 'Room Not Found');
            }

            // Check capacity.
            if ($room->guest_count >= $room->capacity) {
                return response()->error(422, 'Exceeded Capacity Error');
            }

            $pid = $request->profile_id;

            // Check if the Profile exists.
            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404);
            }

            // Add the Guest.
            $room->guests()->attach($pid);
            $room->increment('guest_count');

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve a Guest of a Room.
     *
     * @return App\Models\Profile|Response
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
     * Delete a Guest of a Room.
     *
     * @return Response
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
