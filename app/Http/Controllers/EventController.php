<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\EventRequest;
use App\Models\Event;

class EventController extends Controller
{
    public function index($conference)
    {
        try {
            return Event::where('conference_id', $conference)->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function store(EventRequest $request)
    {
        try {
            Event::create($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }


    public function update(EventRequest $request, $id)
    {
        try {
            Event::findOrFail($id)->update($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function destroy($id)
    {
        try {
            Event::findOrFail($id)->delete();
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function indexWithStatus(Request $request)
    {
        try {
            return Event::where('status', $request->status)->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function updateWithStatus(Request $request, $id)
    {
        try {
            Event::findOrFail($id)->update([
                'status' => $request->status,
            ]);
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
