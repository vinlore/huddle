<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Conference as Conference;
use App\Models\User as User;

require app_path().'/helpers.php';

class ConferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Conference::all();
    }

   // public function dev


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){

        $user_id = $request->id;
        $api_token = $request->apiToken;

         
        $new_conference_data = array(
            'name'                  => $request->name, 
            'description'           => $request->description,
            'start_date'            => $request->startDate,
            'end_date'              => $request->endDate,
            'address'               => $request->address,
            'city'                  => $request->city,
            'country'               => $request->country,
            'attendee_count'        => $request->attendee_count,
            'capacity'              => $request->capacity,
            'status'                => $request->status 
        ); 

        $check = userCheck($user_id,$api_token);
        
        if(false){

            $response = array('status' => 'error', 'message' => 'user/api_token mismatch');

        }   else{

                $user = \Sentinel::findById($user_id);

                if($user->hasAccess(['conference.store'])){

                    Conference::create($new_conference_data);
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

          $new_conference_data = array(
            'name'                  => $request->name, 
            'description'           => $request->description,
            'start_date'            => $request->startDate,
            'end_date'              => $request->endDate,
            'address'               => $request->address,
            'city'                  => $request->city,
            'country'               => $request->country,
            'attendee_count'        => $request->attendee_count,
            'capacity'              => $request->capacity
        ); 

        $check = userCheck($user_id,$api_token);
        
        if(!$check){

            $response = array('status' => 'error', 'message' => 'user/api_token mismatch');

        }   else{


            $user = \Sentinel::findById($user_id);
            $status = $request->status;
        
            if (!is_null($status) && $user->hasAccess(['conference.status'])){

                Conference::find($id)
                ->update(array('status' => $status));

                $response = array('status' => 'success');

            }elseif(is_null($status) && $user->hasAccess(['conference.update'])){

                Conference::find($id)
                ->update($new_conference_data)
                ->update(array('status' => 'pending'));

                /*
                *TODO: check if user wants email notifcations. If yes, send one. 
                *TODO: ADD notification column to user table.
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
