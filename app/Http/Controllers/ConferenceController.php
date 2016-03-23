<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ConferenceRequest;

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
        $conferences = Conference::all();

        if (!$conferences) {
            return \Response::json(array(
                'status' => 'error',
                'message' => 'No conferences could be found.'
            ));
        }

        return $conferences;
    }

   // public function dev

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(ConferenceRequest $request){

        $user_id = $request->header('ID');
        $api_token = $request->header('X-Auth-Token');

        $check = userCheck($user_id,$api_token);
        
        if(!$check){

            $response = array('status' => 'error', 'message' => 'Access denied.');

        }   else{

                $user = \Sentinel::findById($user_id);

                if(true){

                    Conference::create($request->all());
                    $response = array('status' => 'success');

                }   else{

                    $response = array('status' => 'error', 'message' => 'You do not have permission to access this.');
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
        $conference = Conference::find($id);

        if(!$conference) {
            \Response::json(array(
                'status' => 'error',
                'message' => 'Conference could not be found.'
            ));
        }

        return $conference;
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

        $user_id = $request->header('ID');
        $api_token = $request->header('X-Auth-Token');

        $new_conference_data = array(
            'name'                  => $request->name, 
            'description'           => $request->description,
            'start_date'            => $request->start_date,
            'end_date'              => $request->end_date,
            'address'               => $request->address,
            'city'                  => $request->city,
            'country'               => $request->country,
            'capacity'              => $request->capacity
        ); 

        $check = userCheck($user_id,$api_token);
        
        if(!$check){

            $response = array('status' => 'error', 'message' => 'Access denied.');

        }else{


            $user = \Sentinel::findById($user_id);
            $status = $request->status;
        
            if (!is_null($status) && $user->hasAccess(['conference.status'])){

                Conference::find($id)
                ->update(array('status' => $status));

                $response = array('status' => 'success');

            }elseif(is_null($status) && $user->hasAccess(['conference.update'])){

                Conference::find($id)
                ->update($new_conference_data);

                /*
                *TODO: check if user wants email notifcations. If yes, send one. 
                *TODO: ADD notification column to user table.
                */

                $response = array('status' => 'success');

            }else{

                $response = array('status' => 'error', 'message' => 'You have no permission to access this.');

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
