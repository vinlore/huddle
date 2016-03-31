<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\ConferenceAttendeeRequest;
use App\Models\Conference;
use App\Models\Profile;
use App\Models\Vehicle;
use App\Models\Room;
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

            $profile->conferences()->attach($cid, $request->except('profile_id'));

           //$this->addActivity($request->header('ID'),'request', $cid, 'conference application', $pid);

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
            return $conference->attendees()->where('profile_id', $pid)->first();
        } catch (Exception $e) {
            return response()->error();
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

            //Updating the pivot
            $attendees = $conference->attendees()
                                    ->updateExistingPivot($pid, $request->all());

            //Add Activity to log
          //$this->addActivity($request->header('ID'), $request->status, $request->conference_id, 'conference application', $request->profile_id);

            //Update attendee count for Conference
            /*$count = Conference::find($cid)
                                ->attendees()
                                ->where('status','approved')
                                ->count();

            Conference::where($request->conference_id)->update(['attendee_count' => $count]);*/

            // // IF DENIED - Deny all associated events
            // if ($request->status == 'denied' || $request->status != 'cancelled') {
            //     /*
            //     *   Deny all assocaited event to the conference being denied from
            //     */
            //     //Find all events_id associated to this profile_id denied/cancelled from conference_id
            //     $profile_events = Profile::find($pid)->events();
            //     $event_id_array = $profile_events->where('conference_id',$cid)->get();
            //
            //     //Loop through each event_id to change profileAttendEvent status to denied/cancel
            //     foreach($event_id_array as $eid) {
            //         //Update Status to Denied/Cancelled
            //         $profile_events->where('event_id',$eid->id)
            //                        ->updateExistingPivot($eid->id,['status' => $request->status]);
            //
            //         //Update Event attendee count
            //         $count = Event::find($eid->id)->attendees()->where('status','approved')->count();
            //         Event::where($eid_id)->update(['attendee_count' => $count]);
            //     }
            //
            // } elseif ($request->status == 'approved') {
            //     if ($request->vehicle_id != NULL) {
            //     // Link up profile with the vehicle
            //     $profile = Profile::find($request->profile_id);
            //     Vehicle::find($request->vehicle_id)
            //             ->passengers()
            //             ->attach($profile);
            //     }
            //
            //     if ($request->room_id != NULL) {
            //     //Link up the profile with the room
            //     $profile = Profile::find($request->profile_id);
            //     Room::find($request->room_id)
            //             ->guests()
            //             ->attach($profile);
            //     }
            //}
            //send Email Notification
            //$this->sendAttendeeEmail("conference", $request->conference_id, $request->status, $request->profile_id);
            return response()->success();
         } catch (Exception $e) {
            return response()->error($e);
        }
    }

    public function destroy(Request $request, $cid, $pid)
    {
        try {
            Profile::find($pid)->conferences()->detach($cid);

            //Add Activity to log
            //$this->addActivity($request->header('ID'),'deleted', $cid, 'conference application', $pid);
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
