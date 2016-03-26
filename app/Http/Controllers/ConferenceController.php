<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Requests\ConferenceRequest;

use App\Models\Conference as Conference;
use App\Models\User as User;


class ConferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $conferences = Conference::all();
            if (!$conferences) {
                return response()->error("No conferences found.");
            }
            return $conferences;
        } catch (Exception $e) {
            return response()->error("500" , $e);
        }
    }

    //MAKE SEPARATE METHOD FOR STATUS
   public function statusIndex(Request $request)
   {
       try {
           $conferences = Conference::where('status' , $request->status)->get();
           if (!$conferences) {
               return response()->error(null,"No conferences found.");
           }
           return $conferences;
       } catch (Exception $e) {
           return response()->error("500" , $e);
       }
   }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(ConferenceRequest $request){
        try{
            Conference::create($request->all());
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
    public function show($conferences){
        try{
            $conference = Conference::find($conferences);
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

     public function conferenceStatusUpdate(Request $request){
        try{
            $conference = Conference::find($request->id);
            if(!$conference){
                return response()->success("204","No conference found.");
            }
            $conference->update(['status' => $request->status]);
            /*
            if($request->Status == 'approved' && user_to_check->receive_email == 1){
                //TODO SEND APPROVED EMAIL
            }elseif($request->Status == 'declined' && user_to_check->receive_email == 1){
                //TODO SEND DECLINED EMAIL
            }    */
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
            $conference = Conference::find($id);
            if(!$conference){
                return response()->success("204","No conference found.");
            }
            $conference->update($request->all());
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
    public function destroy(ConferenceRequest $request, $conferences){

    try{
        if(!Conference::find($conferences)){
             return response()->error("No conferences found.");
        }

        Conference::destroy($conferences);

        return response()->success();
     }catch (Exception $e) {
            return response()->error($e);
        }
    }
}
