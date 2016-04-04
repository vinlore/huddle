<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Event;
use App\Models\User;

class EventManagerController extends Controller
{
    /**
     * Retrieve all Managers of an Event.
     *
     * @return Collection|Response
     */
    public function index($events)
    {
        return Event::find($events)->managers()->get(['username', 'id', 'email']);
    }

    /**
     * Create a Manager for an Event.
     *
     * @return Response
     */
    public function store(Request $request){
        try{
            //Saving to user_Manages_Event Table
            $event = Event::find($request->events);
            if (!$event) {
                return response()->error(404);
            }
            User::find($request->user_id)
                        ->Events()
                        ->attach($event);

            return response()->success();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Retrieve a Manager of an Event.
     *
     * @return App\Models\User|Response
     */
    public function show($id){
        try{
            $user = User::find($id)->Events()->get();
            if(!$event){
                return response()->success("204", "No Event found.");
            }
            return $event;
        } catch (Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Delete a Manager of an Event.
     *
     * @return Response
     */
    public function destroy($events, $managers){
        try{
            //Deleting from the user_manages_Events table
            $event = Event::find($events);
            User::find($managers)
                        ->Events()
                        ->detach($event);
            return response()->success();
        } catch (Exception $e) {
                return response()->error($e);
        }
    }
}
