<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Requests\ConferenceRequest;

use App\Models\Conference as Conference;
use App\Models\User as User;


class UserManagesConferenceController extends Controller
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
            //Saving to user_Manages_conference Table
            $conference = Conference::find($request->conference_id);
            User::find($request->user_id)
                        ->conferences()
                        ->attach($conference);
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
            $user = User::find($id)->conferences()->get();
            if(!$conference){
                return response()->success("204", "No conference found.");
            }
            return $conference;
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
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request){
        try{
            //Deleting from the user_manages_conferences table
            $conference =  Conference::find($request->conference_id);
            User::find($request->user_id)
                        ->conferences()
                        ->detach($conference);
            return response()->success();
        } catch (Exception $e) {
                return response()->error($e);
        }
    }
}
