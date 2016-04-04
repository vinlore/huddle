<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Conference;
use App\Models\User;

class ConferenceManagerController extends Controller
{
    /**
     * Retrieve all Managers of a Conference.
     *
     * @return Collection|Response
     */
    public function index($conferences)
    {
        return Conference::find($conferences)->managers()->get(['username', 'id', 'email']);
    }

    /**
     * Create a Manager for a Conference.
     *
     * @return Response
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
     * Retrieve a Manager of a Conference.
     *
     * @return App\Models\User|Response
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
     * Delete a Manager of a Conference.
     *
     * @return Response
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
