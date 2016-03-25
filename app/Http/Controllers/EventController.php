<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Models\Event as Event;

require app_path().'/helpers.php';

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       try{
            $events = Event::all();
            if (!$events) {
                return response()->error("No events found.");
            }
            return $events;
        } catch (Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        try {
            Event::create($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error("500",$e);
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
        try{
            $event = Event::find($id);
            if(!$event){
                return response()->success("204","No event found.");
            }
            return $event;
        } catch (Exception $e) {
            return response()->error($e);
        }
    }

     /**
     * Update the status of the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function eventStatusUpdate(EventRequest $request){

        try{
            $user_to_check = User::find($request->header('ID'));

            $event = Event::find($request->id);
            if(!$event){
                 return response()->success("204","No event found.");
            }
            $conference->update(['status' => $request->status]);
               /*

            if($request->Status == 'approved' && user_to_check->receive_email == 1){
                //TODO SEND APPROVED EMAIL

            }elseif($request->Status == 'declined' && user_to_check->receive_email == 1){
                //TODO SEND DECLINED EMAIL
            }    */
            return response()->success();
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
    public function update(EventRequest $request, $id)
    {
        try{
            $event = Event::find($id);
            if(!$event){
                 return response()->success("204","No event found.");
            }
            $event->update($request->all());
            /*
            *TODO: check if user wants email notifcations. If yes, send one.
            *TODO: ADD notification column to user table.
            */
            return response()->success();
         } catch (Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventRequest $id)
    {
        try{
           if(!Event::find($id)){
               return response()->success("204","No Event found");
            }
            Event::destroy($id);
            return response()->success();
         } catch (Exception $e) {
             return response()->error($e);
        }
    }
}
