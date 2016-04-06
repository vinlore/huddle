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
     * @param  Request  $request
     * @param  int  $cid
     * @return Collection|Response
     */
    public function index(Request $request, $cid)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            return $conference->managers()->get(['username', 'id', 'email']);
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create a Manager for a Conference.
     *
     * @param  Request  $request
     * @param  int  $cid
     * @return Response
     */
    public function store(Request $request, $cid)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $uid = $request->user_id;
            $user = User::find($uid);
            if (!$user) {
                return response()->error(404, 'User Not Found');
            }

            $conference->managers()->attach($user);

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete a Manager of a Conference.
     *
     * @param  Request  $request
     * @param  int  $cid
     * @param  int  $uid
     * @return Response
     */
    public function destroy(Request $request, $cid, $uid)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $user = User::find($uid);
            if (!$user) {
                return response()->error(404, 'User Not Found');
            }

            $conference->managers()->detach($user);

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
