<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\RoomRequest;
use App\Models\Room;

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
            Room::create($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
    

    public function update(RoomRequest $request, $id)
    {
        try {
            Room::findOrFail($id)->update($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function destroy($id)
    {
        try {
            Room::findOrFail($id)->delete();
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
