<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Requests\EventRequest;

use App\Models\Event as Event;
use App\Models\Profile as Profile;


class EventAttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($events)
    {
        return Event::find($events)->attendees()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(EventRequest $request, $events){
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
    public function show($id, $profile_id){
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

     public function profileEventStatusUpdate(Request $request){
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

            //IF DENIED - WHAT HAPPENS
            //Detach all related vehicles to this profile for event
            if ($request->status == 'denied' || $request->status != 'cancelled') {
                /*
                *Detatch all related vehicles for this profile for this conference
                */
                //Find all the Vehicle_id associated with this profile
                $vehicle_id = Profile::find($request->profile_id)->vehicles()->get(['id']);

                //Loop through array of vehicle_id
                foreach($vehicle_id as $vid)
                {
                    //Grab all event_id associated to this vehicle
                    $event_id = Vehicle::find($vid->id)
                                    ->events()
                                    ->get(['event_id']);

                   foreach($event_id as $id)
                   {
                       //if event_id matches the one being rejected
                       if ($request->event_id == $id->event_id)
                       {
                           Vehicle::find($vid->id)
                                   ->passengers()
                                   ->detach(Profile::find($request->profile_id));
                       }
                   }
                }
            } elseif($request->status == 'approved') {
                if ($request->vehicle_id != NULL) {
                    // Link up profile with the vehicle
                    $profile = Profile::find($request->profile_id);
                    Vehicle::find($request->vehicle_id)
                            ->passengers()
                            ->attach($profile);
                }
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
    public function update(Request $request, $events, $profiles){
        try {
            //Update
            $attendees = Event::find($events)
                         ->attendees()
                         ->updateExistingPivot($profiles,$request->all());

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

    public function destroy($eid, $pid)
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
