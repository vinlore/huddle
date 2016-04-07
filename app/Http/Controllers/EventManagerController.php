<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Event;
use App\Models\User;

class EventManagerController extends Controller
{
    /**
     * Retrieve all Managers of an Event.
     *
     * @param  Request  $request
     * @param  int  $eid
     * @return Collection|Response
     */
    public function index(Request $request, $eid)
    {
        try {
            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            return $event->managers()->get(['username', 'id', 'email']);
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create a Manager for an Event.
     *
     * @param  Request  $request
     * @param  int  $eid
     * @return Response
     */
    public function store(Request $request, $eid)
    {
        try {
            $user = $this->isEventManager($request, $eid);
            if (!$user) {
                return response()->error(403, 'You are not a manager of this event!');
            }

            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            $uid = $request->user_id;
            $user = User::find($uid);
            if (!$user) {
                return response()->error(404, 'User Not Found');
            }

            $event->managers()->attach($user);

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete a Manager of an Event.
     *
     * @param  Request  $request
     * @param  int  $eid
     * @param  int  $uid
     * @return Response
     */
    public function destroy(Request $request, $eid, $uid)
    {
        try {
            $user = $this->isEventManager($request, $eid);
            if (!$user) {
                return response()->error(403, 'You are not a manager of this event!');
            }

            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            $user = User::find($uid);
            if (!$user) {
                return response()->error(404, 'User Not Found');
            }

            $event->managers()->detach($user);

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
