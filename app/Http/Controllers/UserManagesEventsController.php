<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Requests\EventRequest;

use App\Models\Event as Event;
use App\Models\User as User;


class UserManagesEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($events)
    {
        return Event::find($events)->managers()->get(['username', 'id', 'email']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
        try{
            //Saving to user_Manages_Event Table
            $event = Event::find($request->events);
            User::find($request->user_id)
                        ->Events()
                        ->attach($event);
            return response()->success();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
