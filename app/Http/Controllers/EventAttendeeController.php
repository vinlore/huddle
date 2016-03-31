<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Sentinel;

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventAttendeeRequest $request, $eid, $profiles_id){
        try {

            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404);
            }

            $profile = Profile::find($profile_id);
            if (!$profile) {
                return response()->error(400);
            }

            switch ($request->status) {
                case 'approved':
                    // Check if the User is managing the Event.
                    if (!$this->isEventManager($request, $eid)) {
                        return response()->error(403);
                    }


                    //Check if previously pending or denied
                    $profile_status = \DB::table('profile_attends_events')
                                    ->where('profile_id',$profiles_id)
                                    ->where('event_id',$events_id)
                                    ->pluck('status');

                        if (!(($profile_status[0] == 'pending') || ($profile_status[0] == 'approved')))
                        {
                            return response()->error(403);
                        }

                    //Updating the pivot
                    $events->attendees()->updateExistingPivot($profiles_id, $request->all());

                    //Update attendee count for Conference
                    $count = Event::find($eid)
                                        ->attendees()
                                        ->where('status','approved')
                                        ->count();

                    Event::where('id',$eid)->update(['attendee_count' => $count]);

                    if ($request->vehicle_id != NULL) {
                        // Link up profile with the vehicle
                        $profile = Profile::find($profiles_id);
                        Vehicle::find($request->vehicle_id)
                                ->passengers()
                                ->attach($profile);

                        //UPDATE PASSENGER COUNT
                        $passenger_count = Vehicle::find($request->vehicle_id)->passengers()->count();
                        Vehicle::where('id',$request->vehicle_id)->update(['passenger_count' => $passenger_count]);
                    }
                    break;

                //Change Status to denied
                case 'denied':
                    //Check if conference manager belongs to this conference OR admin
                    $userId = $request->header('ID');
                    if (!$conference->managers()->where('user_id', $userId)->get() ||
                        Sentinel::findById($userId)->roles()->first()->name != 'System Administrator') {
                        return response()->error(403);
                    }

                    //Check if previously pending
                    $profile_status = \DB::table('profile_attends_events')
                                    ->where('profile_id',$profiles_id)
                                    ->where('conference_id',$events_id)
                                    ->pluck('status');

                    if (!($profile_status[0] == 'pending'))
                    {
                        return response()->error(403);
                    }

                    //Updating the pivot
                    $event->attendees()->updateExistingPivot($profiles_id, $request->all());
                    break;

                case 'pending':
                    //Check User Owns the Profile
                    $userId = $request->header('ID');
                    $current_event = User::find($userId)->profiles()->where('id',$profiles_id)->first();
                    if (!$current_event ||
                        !$conference->managers()->where('user_id', $userId)->get() ||
                        Sentinel::findById($userId)->roles()->first()->name != 'System Administrator') {
                        return response()->error(403);
                    }

                    //Check if previously approved
                    $profile_status = \DB::table('profile_attends_conferences')
                                    ->where('profile_id',$pid)
                                    ->where('conference_id',$cid)
                                    ->pluck('status');

                    if (!($profile_status[0] == 'approved'))
                    {
                        return response()->error(403);
                    }

                    //Updating the pivot
                    $event->attendees()->updateExistingPivot($profiles_id, $request->all());
                    break;
                case 'cancelled':
                     // Check if the Profile belongs to the User.
                     $userId = $request->header('ID');
                     $current_event = User::find($userId)->profiles()->where('id',$pid)->first();
                     if (!$current_event) {
                         return response()->error(403);
                     }

                    /*
                    *Detatch all related vehicles for this profile for this conference
                    */
                    //Find all the Vehicle_id associated with this profile
                    $vehicle_id = Profile::find($request->profiles_id)->vehicles()->get(['id']);
                    //Loop through array of vehicle_id
                    foreach($vehicle_id as $vid)
                    {
                        //Grab all event_id associated to this vehicle
                        $eid = Vehicle::find($vid->id)
                                        ->events()
                                        ->get(['event_id']);
                       foreach($eid as $id)
                       {
                           //if event_id matches the one being rejected
                           if ($eid == $id->event_id)
                           {
                               Vehicle::find($vid->id)
                                       ->passengers()
                                       ->detach(Profile::find($profiles_id));
                           }
                       }

                       //Update Event Vehicle passenger
                       $passenger_count = Vehicle::find($vid->id)->passengers()->count();
                       Vehicle::where('id',$vid->id)->update(['passenger_count' => $passenger_count]);
                    }

                    /*
                    *   Remove associated Event
                    */
                    Profile::find($profiles_id)->events()->detach($eid);
                    break;
                default:
                    return response()->error(404);

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
