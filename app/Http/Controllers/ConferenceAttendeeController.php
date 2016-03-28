<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Requests\ConferenceRequest;

use App\Models\Conference as Conference;
use App\Models\Profile as Profile;
use App\Models\Vehicle as Vehicle;
use App\Models\Rooms as Room;
use App\Models\User as User;

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

           $this->addActivity($request->header('ID'),'request', $request->profile_id, 'conference attendence');

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
    public function show($id, $user_id){
        try{
            $conference = Conference::find($id);
            if(!$conference){
                return response()->success("204", "No conference found.");
            }
            return $conference->attendee($user_id)->get();
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
            $attendees = Conference::find($requset->conference_id)
                         ->attendees()
                         ->updateExistingPivot($request->profile_id,['status' => $request->status]);

            $this->addActivity($request->header('ID'),$request->status, $attendees->id, 'conference attendence');

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

            /*
            if($request->Status == 'approved' && user_to_check->receive_email == 1){
                //TODO SEND APPROVED EMAIL
            }elseif($request->Status == 'declined' && user_to_check->receive_email == 1){
                //TODO SEND DECLINED EMAIL
            }
            */
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
    public function update(ConferenceRequest $request, $id){
        try {
            //Update
            $attendees = Conference::find($request->conference_id)
                         ->attendees()
                         ->updateExistingPivot($request->profile_id,$request->all());

            $this->addActivity($request->header('ID'),'update', $attendees->id, 'conference attendence');
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
}
