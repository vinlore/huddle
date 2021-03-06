<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Sentinel;

use App\Models\Activity;

class ActivityController extends Controller
{
    /**
     * Retrieve all Activities.
     *
     * @param  Request  $request
     * @return Collection|Response
     */
    function index(Request $request)
    {
        try {
            return Activity::all();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve all Activities for a User.
     *
     * @param  Request  $request
     * @param  int  $uid
     * @return Collection|Response
     */
    function indexWithUser(Request $request, $uid)
    {
        try {
            $user = Sentinel::findById($uid);
            if (!$user) {
                return response()->error(404, 'User Not Found');
            }

            return $user->activities()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
