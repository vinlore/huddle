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
            $event = Event::create($request->all());
            User::find($request->header('ID'))
                ->events()->attach($event->id);
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }


    public function update(EventRequest $request, $conferences, $id)
    {
        try {
            Event::findorFail($id)->update($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function destroy($conferences, $id)
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
            $this->sendCreationEmail('event', $id, $request->status);
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
