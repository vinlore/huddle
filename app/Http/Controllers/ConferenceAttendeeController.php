<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Sentinel;

use App\Http\Requests\ConferenceAttendeeRequest;

use App\Models\Conference;
use App\Models\Event;
use App\Models\Profile;
use App\Models\Room;
use App\Models\User;
use App\Models\Vehicle;

class ConferenceAttendeeController extends Controller
{
    /**
     * Retrieve all Attendees of a Conference.
     *
     * @return Collection|Response
     */
    public function index(ConferenceAttendeeRequest $request, $cid)
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

            $this->addActivity($request->header('ID'),'request', $cid, 'conference application', $pid);

            return response()->success();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Retrieve an Attendee of a Conference.
     *
     * @return App\Models\Profile|Response
     */
    public function show(ConferenceAttendeeRequest $request, $cid, $pid)
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
     * Update an Attendee of a Conference.
     *
     * @return Response
     */
    public function update(ConferenceAttendeeRequest $request, $cid, $pid)
    {
        try {

            // Check if the Conference exists.
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            // Check if the Profile exists.
            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            $userId = $request->header('ID');
            $profileOwnerId = $profile->user()->first()->id;

            if ($userId != $profileOwnerId) {
                if (!$this->isConferenceManager($request, $cid)) {
                    return response()->error(403);
                }
            }

            if ($request->exists('status')) {

                $oldStatus = $conference->attendees()->where('profile_id', $pid)->first()->pivot->status;
                $newStatus = $request->status;

                switch ($newStatus) {
                    case 'approved':
                        if ($oldStatus != 'pending') {
                            return response()->error(403);
                        }
                        $conference->increment('attendee_count');
                        break;
                    case 'denied':
                        if ($oldStatus != 'pending') {
                            return response()->error(403);
                        }
                        // $conference->decrement('attendee_count');
                        break;
                    case 'pending':
                        if ($oldStatus != 'denied') {
                            return response()->error(403);
                        }
                        break;
                    default:
                        return response()->error(422);
                        break;
                }
            }
            $profile->conferences()->updateExistingPivot($cid, $request->all());
            $this->addActivity($request->header('ID'),'update', $cid, 'conference application', $pid);
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete an Attendee of a Conference.
     *
     * @return Response
     */
    public function destroy(ConferenceAttendeeRequest $request, $cid, $pid)
    {
        try {

            //Find all the Vehicle_id associated with this profile
                   $vehicle_id_array = Profile::find($pid)->vehicles()->get(['id']);
                   //Loop through array of vehicle_id
                   foreach($vehicle_id_array as $vid)
                   {
                       //Grab all conference_id associated to this vehicle
                       $conference_id = Vehicle::find($vid->id)
                                      ->conferences()
                                      ->get(['conference_id']);
                      foreach($conference_id as $id)
                      {
                          //if conference_id matches the one being rejected
                          if ($cid == $id->conference_id)
                          {
                              Vehicle::find($vid->id)
                                      ->passengers()
                                      ->detach(Profile::find($pid));
                          }
                      }
                      //Grab all event_id associated to this vehicle
                      $event_id = Vehicle::find($vid->id)
                                      ->events()
                                      ->get();
                       foreach($event_id as $id)
                       {
                           //if conference_id matches the one being rejected
                           if ($cid == $id->conference_id) {
                               Vehicle::find($vid->id)
                                       ->passengers()
                                       ->detach(Profile::find($pid));
                           }
                       }
                       //Update Event Vehicle passenger
                       $passenger_count = Vehicle::find($vid->id)->passengers()->count();
                       Vehicle::where('id',$vid->id)->update(['passenger_count' => $passenger_count]);
                   }

                   /*
                    *   Remove all Rooms assocaited to profile going to conference_id
                    */
                    //Find all the room_id associated with this profile_id
                    $room_id_array = Profile::find($pid)->rooms()->get();

                   //for each accomodation_id check if matches conference
                    foreach($room_id_array as $rid)
                    {
                       //check each accomm for conference_id
                       $accom = Conference::find($cid)
                                           ->accommodations()
                                           ->where('accommodation_id',$rid->accommodation_id)
                                           ->get();
                       if ($accom) {
                           Room::find($rid->id)
                               ->guests()
                               ->detach(Profile::find($pid));
                       }

                       //Update Room Count
                       $room_count = Room::find($rid->id)->guests()->count();
                       Room::where('id',$rid->id)->update(['guest_count' => $room_count]);
                    }

                   /*
                    *   Remove all associated event to the conference being denied from
                    */
                    //Find all events assocaited to this pid going to the cid
                    $event_id_array = Profile::find($pid)
                                               ->events()
                                               ->where('conference_id',$cid)
                                               ->get();
                   foreach($event_id_array as $eid){
                        $current_event = Event::find($eid->id)->attendees();

                        //Detach all events
                        $current_event->detach(Profile::find($pid));

                        //Update Event attendee count
                        $count = $current_event->where('status','approved')->count();
                        Event::where('id',$eid_id)->update(['attendee_count' => $count]);
                   }

            Profile::find($pid)->conferences()->detach($cid);

            //Add Activity to log
            $this->addActivity($request->header('ID'),'deleted', $cid, 'conference application', $pid);
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
