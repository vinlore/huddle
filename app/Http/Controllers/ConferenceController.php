<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\ConferenceRequest;
use App\Models\Conference;
use App\Models\User;

class ConferenceController extends Controller
{
    /**
     * Retrieve all Conferences of a certain status.
     *
     * @return Collection|Response
     */
    public function indexWithStatus($status)
    {
        try {
            return Conference::where('status', $status)->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve all Conferences.
     *
     * @return Collection|Response
     */
    public function index()
    {
        try {
            return Conference::all();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create a Conference and assign the creator as its Manager.
     *
     * @return Response
     */
    public function store(ConferenceRequest $request)
    {
        try {

            // Create the Conference.
            $conference = Conference::create($request->all());

            // Check if the API token in the request matches the API token in the database.
            $apiToken = $request->header('X-Auth-Token');
            $user = User::where('api_token', $apiToken)->first();

            // Assign the User as a Conference Manager.
            $user->conferences()->attach($conference->id);

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve a Conference.
     *
     * @return Model|Response
     */
    public function show($id)
    {
        try {

            // Check if the Conference exists.
            $conference = Conference::find($id);
            if (!$conference) {
                return response()->error(404);
            }

            // Retrieve the Conference.
            return $conference;
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update a Conference.
     *
     * @return Response
     */
    public function update(ConferenceRequest $request, $id)
    {
        try {
            // Check if the Conference exists.
            $conference = Conference::find($id);
            if (!$conference) {
                return response()->error(404);
            }

            //Check if conference manager belongs to this conference OR admin
            $userId = $request->header('ID');
            if (!$conference->managers()->where('user_id', $userID)->get() ||
                Sentinel::findById($userId)->roles()->first()->name != 'System Administrator') {
                return response()->error("403" , "Permission Denied");
            }


            // Update the Conference.
            $conference->fill($request->all())->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete an Conference.
     *
     * @return Response
     */
    public function destroy($id)
    {
        try {

            // Check if the Conference exists.
            $conference = Conference::find($id);
            if (!$conference) {
                return response()->error(404);
            }

            //Check if event manager belongs to this event OR admin
            $userId = $request->header('ID');
            if (!$conference->managers()->where('user_id', $userID)->get()||
                Sentinel::findById($userId)->roles()->first()->name !='System Administrator') {
                return response()->error("403" , "Permission Denied");
            }

            // Delete the Conference.
            $conference->delete();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
