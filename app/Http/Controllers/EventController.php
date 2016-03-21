<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Event as Event;

require app_path().'/helpers.php';

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = $request->id;
        $api_token = $request->apiToken;

        $new_event_data = array(
            'coference_id'          => $request->conference_id,
            'name'                  => $request->name, 
            'description'           => $request->description,
            'facilitator'           => $request->facilitator,
            'date'                  => $request->date,
            'start_time'            => $request->start_time,
            'end_time'              => $request->end_time,
            'address'               => $request->address,
            'city'                  => $request->city,
            'country'               => $request->country,
            'age_limit'             => $request->age_limit,
            'gender_limit'          => $request->gender_limit,
            'attendee_count'        => $request->attendee_count,
            'capacity'              => $request->capacity,
            'status'                => 'pending'
        ); 

        $check = userCheck($user_id,$api_token);
        
        if(!$check){

            $response = array('status' => 'error', 'message' => 'user/api_token mismatch');

        }   else{

                $user = \Sentinel::findById($user_id);

                if($user->hasAccess(['event.store'])){

                    Event::create($new_event_data);
                    $response = array('status' => 'success');

                }   else{

                    $response = array('status' => 'error', 'message' => 'user does not have permission to perform this action');
                }

        }

        return \Response::json($response); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $user_id = $request->id;
        $api_token = $request->apiToken;

        $new_event_data = array(
            'coference_id'          => $request->conference_id,
            'name'                  => $request->name, 
            'description'           => $request->description,
            'facilitator'           => $request->facilitator,
            'date'                  => $request->date,
            'start_time'            => $request->start_time,
            'end_time'              => $request->end_time,
            'address'               => $request->address,
            'city'                  => $request->city,
            'country'               => $request->country,
            'age_limit'             => $request->age_limit,
            'gender_limit'          => $request->gender_limit,
            'attendee_count'        => $request->attendee_count,
            'capacity'              => $request->capacity
        ); 

        $check = userCheck($user_id,$api_token);
        
        if(!$check){

            $response = array('status' => 'error', 'message' => 'user/api_token mismatch');

        }   else{


            $user = \Sentinel::findById($user_id);
            $status = $request->status;
        
            if (!is_null($status) && $user->hasAccess(['event.status'])){

                Event::find($id)
                ->update(array('status' => $status));

                $response = array('status' => 'success');

            }elseif(is_null($status) && $user->hasAccess(['event.update'])){

                Conference::find($id)
                ->update($new_event_data)
                ->update(array('status' => 'pending'));

                /*
                *TODO: check if user wants email notifcations. If yes, send one. 
                *TODO: ADD notification column to user table lol ;p
                */

                $response = array('status' => 'success');

            }else{

                $response = array('status' => 'error', 'message' => 'user doesnt have permission to perform this action');

            }
        }

        return \Response::json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
