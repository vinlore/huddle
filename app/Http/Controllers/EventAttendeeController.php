<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Requests\EventAttendeeRequest;

use App\Models\Event as Event;
use App\Models\Profile as Profile;


class EventAttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EventAttendeeRequest $request, $events)
    {
        return Event::find($events)->attendees()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(EventAttendeeRequest $request, $events){
        try{
            //Saving to profile_attends_event Table
            $profile =  Profile::find($request->profile_id);
            $attendees = Event::find($events)
                         ->attendees()
                         ->attach($profile, $request->all());

            //Add Activity to log
            $this->addActivity($request->header('ID'),'request', $events, 'event application', $request->profile_id);
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
    public function show(EventAttendeeRequest $request, $id, $profile_id){
        try{
            $event = Event::find($id);
            if(!$event){
                return response()->success("204", "No Event found.");
            }
            return $event->attendees()->where('profile_id', $profile_id)->first();
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

     public function profileEventStatusUpdate(EventAttendeeRequest $request){
        try{
            //Update Status on pivot
            $attendees = Event::find($request->event_id)
                         ->attendees()
                         ->updateExistingPivot($request->profile_id,['status' => $request->status]);

            //Add Activity to log
            $this->addActivity($request->header('ID'),$request->status, $request->event_id, 'event application', $request->profile_id);

            //Update attendee count
            $count = Event::find($request->event_id)
                        ->attendees()
                        ->where('status','approved')
                        ->count();
            Event::where($request->event_id)->update(['attendee_count' => $count]);


                if ($request->vehicle_id != NULL) {
                    // Link up profile with the vehicle
                    $profile = Profile::find($request->profile_id);
                    Vehicle::find($request->vehicle_id)
                            ->passengers()
                            ->attach($profile);
                }


            //Send Email Notification
             $this->sendAttendeeEmail("event", $request->event_id, $request->status, $request->profile_id);
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
    public function update(EventAttendeeRequest $request, $events_id, $profiles_id){
        try {

            $event = Event::find($events_id);

            if(!$event) {
                return response()->error(404);
            }

            //Update
            $attendees = $event->attendees()
                         ->updateExistingPivot($profiles_id,$request->all());

            //Update attendee count
            $count = $event->attendees()
                           ->where('status','approved')
                           ->count();
            Event::where($events_id)->update(['attendee_count' => $count]);

            if($request->status == 'denied' || $request->status == 'cancelled') {

            } elseif($request->status == 'approved') {
                if ($request->vehicle_id != NULL) {

                    // Link up profile with the vehicle
                    $profile = Profile::find($profiles_id);
                    Vehicle::find($request->vehicle_id)
                            ->passengers()
                            ->attach($profile);
                }
            }
            //Add Activity to log
            $this->addActivity($request->header('ID'),'update', $events, 'event application', $profiles);
            /*
            *TODO: check if user wants email notifcations. If yes, send one.
            *TODO: ADD notification column to user table.
            */
            return response()->success();
         } catch (Exception $e) {
            return response()->error($e);
        }
    }

    public function destroy(EventAttendeeRequest $request, $eid, $pid)
    {
        try {
            Profile::find($pid)->events()->detach($eid);

            //Add Activity to log
            $this->addActivity($request->header('ID'),'delete', $eid, 'event application', $pid);

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
