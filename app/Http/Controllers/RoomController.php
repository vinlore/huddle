<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\RoomRequest;

use App\Models\Accommodation;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * Retrieve all Rooms of an Accommodation.
     *
     * @return Collection|Response
     */
    public function index(Request $request, $aid)
    {
        try {

            // Check if the Accommodation exists.
            $accommodation = Accommodation::find($aid);
            if (!$accommodation) {
                return response()->error(404, 'Accommodation Not Found');
            }

            // TODO: Check manager status

            // Retrieve its Accommodations.
            return $accommodation->rooms()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create a Room for an Accommodation.
     *
     * @return Response
     */
    public function store(RoomRequest $request, $aid)
    {
        try {

            // Check if the Accommodation exists.
            $accommodation = Accommodation::find($aid);
            if (!$accommodation) {
                return response()->error(404, 'Accommodation Not Found');
            }

            // TODO: Check manager status

            // Create the Room.
            $room = new Room($request->all());
            $room->accommodation()->associate($accommodation);
            $room->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update a Room of an Accommodation.
     *
     * @return Response
     */
    public function update(RoomRequest $request, $aid, $rid)
    {
        try {

            // Check if the Accommodation exists.
            $accommodation = Accommodation::find($aid);
            if (!$accommodation) {
                return response()->error(404, 'Accommodation Not Found');
            }

            // TODO: Check manager status.

            // Check if the Room exists.
            $room = Room::find($rid);
            if (!$room) {
                return response()->error(404, 'Room Not Found');
            }

            // Update the Room.
            $room->fill($request->all())->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete a Room of an Accommodation.
     *
     * @return Response
     */
    public function destroy(RoomRequest $request, $aid, $rid)
    {
        try {
            // Check if the Accommodation exists.
            $accommodation = Accommodation::find($aid);
            if (!$accommodation) {
                return response()->error(404, 'Accommodation Not Found');
            }

            // TODO: Check manager status.

            // Check if the Room exists.
            $room = Room::find($rid);
            if (!$room) {
                return response()->error(404, 'Room Not Found');
            }

            // TODO: Check existence of guests.

            // Delete the Room.
            $room->delete();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
