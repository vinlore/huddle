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
     * @return Collection|Response
     */
    public function index(Request $request, $cid)
    {
        try {

            // Check if the Conference exists.
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            // Retrieve its Events.
            return $conference->events()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create an Event for a Conference.
     *
     * @return Response
     */
    public function store(EventRequest $request, $cid)
    {
        try {

            // Check if the Conference exists.
            $conference = Conference::find($cid);
            if (!$conference->exists()) {
                return response()->error(404, 'Conference Not Found');
            }

            // Check if the User is managing the Conference.
            if (!$this->isConferenceManager($request, $cid)) {
                return response()->error(403);
            }

            // Create the Event.
            $event = new Event($request->all());
            $event->conference()->associate($conference);
            $event->save();
            $event->managers()->attach($request->header('ID'));

            $this->addActivity($request->header('ID'),'request', $event->id, 'event');

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve an Event of a Conference.
     *
     * @return App\Models\Event|Response
     */
    public function show(EventRequest $request, $cid, $eid)
    {
        try {

            // Check if the Conference exists.
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            // Check if the Event exists.
            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            // Retrieve the Event.
            return $event;
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update an Event of a Conference.
     *
     * @return Response
     */
    public function update(EventRequest $request, $cid, $eid)
    {
        try {

            // Check if the Conference exists.
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            // Check if the Event exists.
            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            if (!$this->isEventManager($request, $eid)) {
                return response()->error(403, 'You are not a manager of this event.');
            }

            if (($request->status == 'approved' || $request->status == 'denied')) {
                $event->update($request->all());
                $this->addActivity($request->header('ID'),$request->status, $eid, 'event');
                $this->sendEventRequestEmail($event->id, $request->status);
            } elseif(($request->status != 'approved' && $request->status != 'denied')) {
                $event->fill($request->all())->save();
                 $this->addActivity($request->header('ID'),'update', $eid, 'event');
            } else {
                return response()->error(403);
            }

            $event->fill($request->all())->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete an Event of a Conference.
     *
     * @return Response
     */
    public function destroy(EventRequest $request, $cid, $eid)
    {
        try {

            // Check if the Conference exists.
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            // Check if the Event exists.
            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            if (!$this->isEventManager($request, $eid)) {
                return response()->error(403, 'You are not a manager of this event.');
            }

            $event->delete();

            //Add Activity to log
            $this->addActivity($request->header('ID'),'delete', $eid, 'event');

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve all Events of a certain status.
     *
     * @return Collection|Response
     */
    public function indexWithStatus(Request $request)
    {
        try {
            return Event::where('status', $request->status)->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
