<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Requests\EventRequest;

use App\Models\Event as Event;
use App\Models\Profile as Profile;


class ProfileAttendsEventController extends Controller
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

    public function store(EventRequest $request){
        try{
            //Saving to profile_attends_event Table
            $profile =  Profile::find($request->profile_id);
            $attendees = Event::find($request->event_id)
                         ->attendees()
                         ->attach($profile, $request->all());

            $this->addActivity($request->header('ID'),'request', $attendees->id, 'event attendence');
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
    public function show($id,$profile_id){
        try{
            $event = Event::find($id);
            if(!$event){
                return response()->success("204", "No Event found.");
            }
            return $event->attendees;
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
            $attendees = Event::find($requset->event_id)
                         ->attendees()
                         ->updateExistingPivot($request->profile_id,['status' => $request->status]);

            $this->addActivity($request->header('ID'),$request->status, $attendees->id, 'event attendence');
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
    public function update(Request $request, $id){
        try {
            //Update
            $attendees = Event::find($requset->event_id)
                         ->attendees()
                         ->updateExistingPivot($request->profile_id,$request->all());
            $this->addActivity($request->header('ID'),'update', $attendees->id, 'event attendence');
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
    public function destroy(Request $request){
    }
}
