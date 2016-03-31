<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Sentinel;

use App\Http\Requests\EventAttendeeRequest;
use App\Models\Event;
use App\Models\Profile;

class EventAttendeeController extends Controller
{
    /**
     * Retrieve all Attendees for an Event.
     *
     * @return Collection|Response
     */
    public function index(EventAttendeeRequest $request, $eid)
    {
        try {

            // Check if the Event exists.
            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            // Retrieve its Attendees.
            return $event->attendees()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create an Attendee for an Event.
     *
     * @return Response
     */
    public function store(EventAttendeeRequest $request, $eid)
    {
        try {

            // Check if the Event exists.
            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            $pid = $request->profile_id;

            // Check if the Profile exists.
            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            $profile->events()->attach($eid, $request->except('profile_id'));
            $this->addActivity($request->header('ID'),'request', $eid, 'event application', $request->profile_id);
            return response()->success();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Retrieve an Event Attendee.
     *
     * @return Model|Response
     */
    public function show(EventAttendeeRequest $request, $eid, $pid)
    {
        try {

            // Check if the Event exists.
            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            // Check if the Profile exists.
            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            // Retrieve the Attendee.
            return $event->attendees()->where('profile_id', $pid)->first();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update an Event Attendee.
     *
     * @return Response
     */
    public function update(EventAttendeeRequest $request, $eid, $pid)
    {
        try {

            // Check if the Event exists.
            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            // Check if the Profile exists.
            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            $userId = $request->header('ID');
            $profileOwnerId = $profile->user()->first()->id;

            if ($userId != $profileOwnerId) {
                if (!$this->isEventManager($request, $eid)) {
                    return response()->error(403);
                }
            }

            if ($request->exists('status')) {

                $oldStatus = $event->attendees()->where('profile_id', $pid)->first()->pivot->status;
                $newStatus = $request->status;

                switch ($newStatus) {
                    case 'approved':
                    case 'denied':
                        if ($oldStatus != 'pending') {
                            return response()->error(403);
                        }
                        break;
                    case 'pending':
                        if ($oldStatus != 'denied') {
                            return response()->error(403);
                        }
                        break;
                    default:
                        return response()->error(422);
                        break;
                }
            }
            $profile->events()->updateExistingPivot($eid, $request->all());
            $this->addActivity($request->header('ID'),'update', $eid, 'event application', $pid);
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function destroy(EventAttendeeRequest $request, $eid, $pid)
    {
        try {
            /*
             * Detatch all related vehicles for this profile for this conference
             */
            //Find all the Vehicle_id associated with this profile
            $vehicle_id = Profile::find($pid)->vehicles()->get(['id']);
            //Loop through array of vehicle_id
            foreach($vehicle_id as $vid)
            {
                //Grab all event_id associated to this vehicle
                $eid = Vehicle::find($vid->id)
                                ->events()
                                ->get(['event_id']);
               foreach($eid as $id)
               {
                   //if event_id matches the one being rejected
                   if ($eid == $id->event_id)
                   {
                       Vehicle::find($vid->id)
                               ->passengers()
                               ->detach(Profile::find($pid));
                   }
               }

               //Update Event Vehicle passenger
               $passenger_count = Vehicle::find($vid->id)->passengers()->count();
               Vehicle::where('id',$vid->id)->update(['passenger_count' => $passenger_count]);
            }
            Profile::find($pid)->events()->detach($eid);

            //Add Activity to log
            $this->addActivity($request->header('ID'),'delete', $eid, 'event application', $pid);

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
