<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Conference;
use App\Models\User;

class ConferenceManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($conferences)
    {
        return Conference::find($conferences)->managers()->get(['username', 'id', 'email']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, $cid){
        try{
            //Saving to user_Manages_conference Table
            $conference = Conference::find($cid)->managers()->attach($request->user_id);
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
    public function destroy($conferences, $managers){
        try{
            //Deleting from the user_manages_conferences table
            $conference =  Conference::find($conferences);
            User::find($managers)
                        ->conferences()
                        ->detach($conference);
            return response()->success();
        } catch (Exception $e) {
                return response()->error($e);
        }
    }
}
