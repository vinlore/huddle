<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Requests\ConferenceAttendeeRequest;

use App\Models\Conference as Conference;
use App\Models\Profile as Profile;
use App\Models\Vehicle as Vehicle;
use App\Models\Rooms as Room;
use App\Models\User as User;
use App\Models\Event as Event;

class ConferenceAttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($conferences)
    {
        return Conference::find($conferences)->attendees()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, $conferences){
        try{
            //Saving to profile_attends_conference Table
            $profile =  Profile::find($request->profile_id);
            $attendees = Conference::find($conferences)
                          ->attendees()
                          ->attach($profile, $request->all());

           $this->addActivity($request->header('ID'),'request', $conferences, 'conference attendence');

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
            $conference = Conference::find($id);
            if(!$conference){
                return response()->success("204", "No conference found.");
            }
            return $conference->attendees()->where('profile_id', $profile_id)->first();
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

     public function profileConferenceStatusUpdate(Request $request){
        try{

            //update status on pivot
            $attendees = Conference::find($request->conference_id)
                         ->attendees()
                         ->updateExistingPivot($request->profile_id,['status' => $request->status]);

            $this->addActivity($request->header('ID'),$request->status, $request->conference_id, 'conference attendence');

            //Update attendee count
            $count = Conference::find($request->conference_id)
                         ->attendees()
                         ->where('status','approved')
                         ->count();
            Conference::where($request->conference_id)->update(['attendee_count' => $count]);

            if($request->status == "denied") {
                $profile = Profile::find($request->profile_id);

                //TODO:Detaching all related Vehicles to this profile for this conference
                //Check all Vehicle ID related to this profile

                //TODO:Detchaing all rooms related to this profile for this conference

                //TODO:Detach all events related to the conference being rejected
                return response()->success();
            }


            if ($request->vehicle_id != NULL) {
                // Link up profile with the vehicle
                $profile = Profile::find($request->profile_id);
                Vehicle::find($request->vehicle_id)
                        ->passengers()
                        ->attach($profile);
            }

            if ($request->room_id != NULL) {
                //Link up the profile with the room
                $profile = Profile::find($request->profile_id);
                Room::find($request->room_id)
                        ->guests()
                        ->attach($profile);
            }

            //send Email Notification
            $this->sendAttendeeEmail("conference", $request->conference_id, $request->status, $request->profile_id);

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
    public function update(ConferenceAttendeeRequest $request, $conference_id, $profile_id){
        try {
            //Update
            $attendees = Conference::find($conference_id)
                         ->attendees()
                         ->updateExistingPivot($profile_id,$request->all());

            $this->addActivity($request->header('ID'),'update', $conference_id, 'conference attendence');

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
    public function destroy(ConferenceRequest $request){
    }

    public function showStatus($cid, $uid) {
        try{
            $conference = Conference::find($cid);
            if(!$conference){
                return response()->success("204", "No conference found.");
            }
            return $conference->attendees()->where('user_id', $uid)->first();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }
}
