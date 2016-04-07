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
     * @param  Request  $request
     * @param  int  $rid
     * @return Collection|Response
     */
    public function index(Request $request, $rid)
    {
        try {
            $room = Room::find($rid);
            if (!$room) {
                return response()->error(404, 'Room Not Found');
            }

            return $room->guests()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create a Guest for a Room.
     *
     * @param  Request  $request
     * @param  int  $rid
     * @return Response
     */
    public function store(Request $request, $rid)
    {
        try {
            $room = Room::find($rid);
            if (!$room) {
                return response()->error(404, 'Room Not Found');
            }

            $pid = $request->profile_id;
            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            if ($room->guest_count >= $room->capacity) {
                return response()->error(422, 'Exceed Capacity Error');
            }

            $room->guests()->attach($profile);
            $room->increment('guest_count');

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete a Guest of a Room.
     *
     * @param  Request  $request
     * @param  int  $rid
     * @param  int  $pid
     * @return Response
     */
    public function destroy(Request $request, $rid, $pid) {
        try {
            $room = Room::find($rid);
            if (!$room) {
                return response()->error(404, 'Room Not Found');
            }

            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            $room->guests()->detach($profile);
            $room->decrement('guest_count');

            return response()->success();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }
}
