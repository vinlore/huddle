<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Sentinel;

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
     * Retrieve a Conference Attendee.
     *
     * @return Model|Response
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
            return $conference->attendees()->where('profile_id', $pid)->get();
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

            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404);
            }

            switch ($request->status) {
                case 'approved':
                    // Check if the User is managing the Conference.
                    if (!$this->isConferenceManager($request, $cid)) {
                        return response()->error(403);
                    }

                    //Check if previously pending or denied
                    $profile_status = \DB::table('profile_attends_conferences')
                                    ->where('profile_id',$pid)
                                    ->where('conference_id',$cid)
                                    ->pluck('status');

                        if (!(($profile_status[0] == 'pending') || ($profile_status[0] == 'approved')))
                        {
                            return response()->error(403);
                        }


                    //Updating the pivot
                    $conference->attendees()->updateExistingPivot($pid, $request->all());

                    //Update attendee count for Conference
                    $count = Conference::find($cid)
                                        ->attendees()
                                        ->where('status','approved')
                                        ->count();

                    Conference::where('id',$cid)->update(['attendee_count' => $count]);


                    if ($request->vehicle_id != NULL) {
                    // Link up profile with the vehicle
                    $profile = Profile::find($request->profile_id);
                    Vehicle::find($request->vehicle_id)
                            ->passengers()
                            ->attach($profile);

                    //UPDATE PASSENGER COUNT
                    $passenger_count = Vehicle::find($request->vehicle_id)->passengers()->count();
                    Vehicle::where('id',$request->vehicle_id)->update(['passenger_count' => $passenger_count]);
                    }

                    if ($request->room_id != NULL) {
                    //Link up the profile with the room
                    $profile = Profile::find($request->profile_id);
                    Room::find($request->room_id)
                            ->guests()
                            ->attach($profile);

                    //Update Room Count
                    $room_count = Room::find($request->room_id)->guests()->count();
                    Room::where('id',$request->room_id)->update(['guest_count' => $room_count]);
                    }
                    break;

                //Change status to denied
                case 'denied':
                    // Check if the User is managing the Conference.
                    if (!$this->isConferenceManager($request, $cid)) {
                        return response()->error(403);
                    }

                    //Check if previously pending
                    $profile_status = \DB::table('profile_attends_conferences')
                                    ->where('profile_id',$pid)
                                    ->where('conference_id',$cid)
                                    ->pluck('status');

                    if (!($profile_status[0] == 'pending'))
                    {
                        return response()->error(403);
                    }

                    //Updating the pivot
                    $conference->attendees()->updateExistingPivot($pid, $request->all());
                    break;

                case 'pending':
                    //Check User Owns the Profile Or it's manager, or it's admin
                    $userId = $request->header('ID');
                    $current_event = User::find($userId)->profiles()->where('id',$pid)->first();
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

                        if ($profile_status[0] == 'approved')
                        {
                            return response()->error(403);
                        }

                    //Updating the pivot
                    $conference->attendees()->updateExistingPivot($pid, $request->all());
                    break;

                case 'cancelled':
                  /*
                   *Detatch all related vehicles for this profile for this conference
                   */
                   //Check if conference manager belongs to this conference OR admin
                   $userId = $request->header('ID');
                   $current_event = User::find($userId)->profiles()->where('id',$pid)->first();
                   if (!$current_event) {
                       return response()->error(403);
                   }

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
                   /*
                   *    Remove the associated conference
                   */
                    Profile::find($pid)->conferences()->detach($cid);
                    break;
                default:
                    return response()->error(404);
            }

            return response()->success();
         } catch (Exception $e) {
            return response()->error($e);
        }
    }


    public function destroy(ConferenceAttendeeRequest $request, $cid, $pid)
    {
        try {
            Profile::find($pid)->conferences()->detach($cid);

            //Add Activity to log
            $this->addActivity($request->header('ID'),'deleted', $cid, 'conference application', $pid);
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
