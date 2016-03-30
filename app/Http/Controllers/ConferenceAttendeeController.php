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

                // IF DENIED - WHAT HAPPENS
                //Detach all events related to the conference being rejected

            if ($request->status == 'denied' || $request->status != 'cancelled') {
                /*
                *Detatch all related vehicles for this profile for this conference
                */
                //Find all the Vehicle_id associated with this profile
                $vehicle_id = Profile::find($request->profile_id)->vehicles()->get(['id']);

                //Loop through array of vehicle_id
                foreach($vehicle_id as $vid)
                {
                    //Grab all conference_id associated to this vehicle
                    $conference_id = Vehicle::find($vid->id)
                                   ->conferences()
                                   ->get(['conference_id']);

                   foreach($conference_id as $id)
                   {
                       //if conference_id matches the one being rejected
                       if ($request->conference_id == $id->conference_id)
                       {
                           Vehicle::find($vid->id)
                                   ->passengers()
                                   ->detach(Profile::find($request->profile_id));
                       }
                   }

                }

                /*
                *   Remove all Rooms assocaited to profile going to conference_id
                */
                //Find all the room_id associated with this profile_id
                $room_id_array = Profile::find($request->profile_id)->rooms()->get();

               //for each accomodation_id check if matches conference
                foreach($room_id_array as $rid)
                {
                   //check each accomm for conference_id
                   $accom = Conference::find($request->conference_id)
                                       ->accommodations()
                                       ->where('accommodation_id',$rid->accommodation_id)
                                       ->get();
                   if ($accom) {
                       Room::find($rid->id)
                           ->guests()
                           ->detach(Profile::find($request->profile_id));
                   }
                }

                /*
                *   Remove all assocaited event to the conference being denied from
                */
                //Find all events assocaited to this profile_id
                $event_id = Profile::find($user_id)
                                           ->events()
                                           ->get();

               foreach($event_id as $eid){
                   if($eid->conference_id == $conference_id) {
                       Event::find($eid->id)
                               ->attendees()
                               ->detach(Profile::find($user_id));
                   }
               }

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

     public function vehicleTest() {
         $request_id = 1;
         $user_id = 1;

         //Find all the Vehicle_id associated with this profile
         $vehicle_id = Profile::find($user_id)->vehicles()->get(['id']);

         //Loop through array of vehicle_id
         foreach($vehicle_id as $vid)
         {
             //Grab all conference_id associated to this vehicle
             $conference_id = Vehicle::find($vid->id)
                            ->conferences()
                            ->get(['conference_id']);
            //var_dump($conference_id);
            foreach($conference_id as $id)
            {
                //if conference_id matches the one being rejected
                if ($request_id == $id->conference_id)
                {
                    Vehicle::find($vid->id)
                            ->passengers()
                            ->detach(Profile::find($user_id));
                }
            }
         }
     }

     public function roomTest()
     {
         $conference_id = 2;
         $user_id = 1;

         //Find all the room_id associated with this profile_id
         $room_id_array = Profile::find($user_id)->rooms()->get();

        //for each accomodation_id check if matches conference
         foreach($room_id_array as $rid)
         {
            //check each accomm for conference_id
            var_dump($rid->id);
            $accom = Conference::find($conference_id)
                                ->accommodations()
                                ->where('accommodation_id',$rid->accommodation_id)
                                ->get();
            if ($accom) {
                Room::find($rid->id)
                    ->guests()
                    ->detach(Profile::find($user_id));
            }
         }
     }

     public function eventTest()
     {
         $conference_id = 1;
         $user_id = 1;

         //Find all events assocaited to this profile_id
         $event_id = Profile::find($user_id)
                                    ->events()
                                    ->get();


        foreach($event_id as $eid){
            if($eid->conference_id == $conference_id)
            {
                Event::find($eid->id)
                        ->attendees()
                        ->detach(Profile::find($user_id));
            }
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
