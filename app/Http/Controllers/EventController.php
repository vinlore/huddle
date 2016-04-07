<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\EventRequest;

use App\Models\Conference;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    /**
     * Retrieve all Events of a Conference.
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

            return $conference->events()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create an Event for a Conference.
     *
     * @param  EventRequest  $request
     * @param  int  $cid
     * @return Response
     */
    public function store(EventRequest $request, $cid)
    {
        try {
            $user = $this->getUser($request);

            $conference = Conference::find($cid);
            if (!$conference->exists()) {
                return response()->error(404, 'Conference Not Found');
            }

            $event = new Event($request->all());
            $event->conference()->associate($conference);
            $event->save();
            $event->managers()->attach($user);

            $this->addActivity($user->id, 'requested', $event->id, 'event');

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve an Event of a Conference.
     *
     * @param  EventRequest  $request
     * @param  int  $cid
     * @param  int  $eid
     * @return App\Models\Event|Response
     */
    public function show(EventRequest $request, $cid, $eid)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            return $event;
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update an Event of a Conference.
     *
     * @param  EventRequest  $request
     * @param  int  $cid
     * @param  int  $eid
     * @return Response
     */
    public function update(EventRequest $request, $cid, $eid)
    {
        try {
            $user = $this->isEventManager($request, $eid);
            if (!$user) {
                return response()->error(403, 'You are not a manager of this event!');
            }

            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            $activityType = 'updated';

            if ($request->exists('status')) {

                $oldStatus = $event->status;
                $newStatus = $request->status;

                switch ($newStatus) {
                    case 'approved':
                    case 'denied':
                        if ($oldStatus != 'pending') {
                            break;
                        }
                        $activityType = $newStatus;
                        $this->sendEventRequestEmail($eid, $newStatus);
                        break;
                    case 'pending':
                        if ($oldStatus != 'denied') {
                            break;
                        }
                        break;
                    default:
                        return response()->error(422);
                        break;
                }
            }

            $event->fill($request->all());
            $event->save();

            $this->addActivity($user->id, $activityType, $eid, 'event');

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete an Event of a Conference.
     *
     * @param  EventRequest  $request
     * @param  int  $cid
     * @param  int  $eid
     * @return Response
     */
    public function destroy(EventRequest $request, $cid, $eid)
    {
        try {
            $user = $this->isEventManager($request, $eid);
            if (!$user) {
                return response()->error(403, 'You are not a manager of this event!');
            }

            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            $event->delete();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve all Events of a certain status.
     *
     * @param  Request  $request
     * @return Collection|Response
     */
    public function indexWithStatus(Request $request, $status)
    {
        try {
            return Event::where('status', $status)->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
