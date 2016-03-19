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

        $check = userCheck($user_id,$api_token);
        
        if(!$check){

            $response = array('status' => 'error', 'message' => 'user/api_token mismatch');

        }   else{

                $user = \Sentinel::findById($user_id);

                if($user->hasAccess(['event.store'])){

                    Event::create($request->all());
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
                ->update($request->all())
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
