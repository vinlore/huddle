<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Requests\ConferenceRequest;

use App\Models\Conference as Conference;
use App\Models\Profile as Profile;

require app_path().'/helpers.php';

class ProfileAttendsConferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(ConferenceRequest $request){
        try{
            //Saving to profile_attends_conference Table
            $profile =  Profile::find($request->profile_id);
            $attendees = Conference::find($request->conference_id)
                          ->attendees()
                          ->attach($profile, $request->all());

           addActivity($request->header('ID'),'request', $attendees->id, 'conference attendence');

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
    public function show($id){
        try{
            $conference = Conference::find($id)->attendees()->get();
            if(!$conference){
                return response()->success("204", "No conference found.");
            }
            return $conference;
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

            addActivity($request->header('ID'),$request->status, $attendees->id, 'conference attendence');
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

            addActivity($request->header('ID'),'update', $attendees->id, 'conference attendence');
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
