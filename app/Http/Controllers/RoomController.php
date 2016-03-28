<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Models\Accommodation;

class RoomController extends Controller
{
    public function index($accommodation)
    {
        try {
            return Room::where('accommodation_id', $accommodation)->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function store(RoomRequest $request)
    {
        try {
            $accommodation = Accommodation::find($request->accommodation_id);
            $room = new Room($request->all());
            $room->accommodation()->associate($accommodation);
            $room->save();
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }


    public function update(RoomRequest $request, $accommodation, $id)
    {
        try {
            Room::findOrFail($id)->update($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function destroy($accommodation, $id)
    {
        try {
            Room::findOrFail($id)->delete();
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
