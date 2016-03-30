<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\ConferenceAttendeeRequest;
use App\Models\Conference;
use App\Models\Profile;
use App\Models\Vehicle;
use App\Models\Rooms;
use App\Models\User;
use App\Models\Event;

class ConferenceAttendeeController extends Controller
{
    /**
     * Retrieve all Attendees for a Conference.
     *
     * @return Collection|Response
     */
    public function index($cid)
    {
        try {

            // Check if the Conference exists.
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404);
            }

            // Retrieve its Attendees.
            return $conference->attendees()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create an Attendee for a Conference.
     *
     * @return Response
     */
    public function store(ConferenceAttendeeRequest $request, $cid)
    {
        try {

            // Check if the Conference exists.
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404);
            }

            $pid = $request->profile_id;

            // Check if the Profile exists.
            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404);
            }

            $profile->conferences()->attach($pid, $request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Retrieve a Conference Attendee.
     *
     * @return Model|Response
     */
    public function show($cid, $pid)
    {
        try {

            // Check if the Conference exists.
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404);
            }

            // Check if the Profile exists.
            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404);
            }

            // Retrieve the Attendee.
            return $conference->attendees()->where('profile_id', $pid)->get();
        } catch (Exception $e) {
            return response()->error();
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

                //TODO : IF DENIED - WHAT HAPPENS
                //TODO:Detaching all related Vehicles to this profile for this conference

                //TODO:Detchaing all rooms related to this profile for this conference

                //TODO:Detach all events related to the conference being rejected



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
     * Update a Conference Attendee.
     *
     * @return Response
     */
    public function update(ConferenceAttendeeRequest $request, $cid, $pid)
    {
        try {

            // Check if the Conference exists.
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404);
            }

            // Check if the Attendee exists.
            $attendee = $conference->attendees()->updateExistingPivot($pid, $request->all());

            return response()->success();
         } catch (Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Delete a Conference Attendee.
     *
     * @return Response
     */
    public function destroy(ConferenceAttendeeRequest $request, $cid, $pid)
    {
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
