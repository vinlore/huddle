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
     * Retrieve all Attendees of an Event.
     *
     * @param  EventAttendeeRequest  $request
     * @param  int  $eid
     * @return Collection|Response
     */
    public function index(EventAttendeeRequest $request, $eid)
    {
        try {
            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            return $event->attendees()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create an Attendee for an Event.
     *
     * @param  EventAttendeeRequest  $request
     * @param  int  $eid
     * @return Response
     */
    public function store(EventAttendeeRequest $request, $eid)
    {
        try {
            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            $pid = $request->profile_id;
            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            $userId = $request->header('ID');
            $profileOwnerId = $profile->user()->first()->id;
            if ($userId != $profileOwnerId) {
                return response()->error(403);
            }

            if ($event->attendee_count >= $event->capacity) {
                return response()->error(422, 'Exceed Capacity Error');
            }

            $activityType = 'requested';

            $event->attendees()->attach($profile, $request->except('profile_id'));

            $this->addActivity($profile->user()->first()->id, $activityType, $eid, 'event application', $pid);

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve an Attendee of an Event.
     *
     * @param  EventAttendeeRequest  $request
     * @param  int  $eid
     * @param  int  $pid
     * @return App\Models\Profile|Response
     */
    public function show(EventAttendeeRequest $request, $eid, $pid)
    {
        try {
            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            return $event->attendees()->where('profile_id', $pid)->first();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update an Attendee of an Event.
     *
     * @param  EventAttendeeRequest  $request
     * @param  int  $eid
     * @param  int  $pid
     * @return Response
     */
    public function update(EventAttendeeRequest $request, $eid, $pid)
    {
        try {
            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

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

            $activityType = 'updated';

            if ($request->exists('status')) {

                $oldStatus = $event->attendees()->where('profile_id', $pid)->first()->pivot->status;
                $newStatus = $request->status;

                switch ($newStatus) {
                    case 'approved':
                        if ($oldStatus != 'pending') {
                            break;
                        }
                        $activityType = $newStatus;
                        $event->increment('attendee_count');
                        break;
                    case 'denied':
                        if ($oldStatus != 'pending') {
                            break;
                        }
                        $activityType = $newStatus;
                        break;
                    case 'pending':
                        if ($oldStatus != 'denied') {
                            break;
                        }
                        $activityType = 'resubmitted';
                        break;
                    default:
                        return response()->error(422);
                        break;
                }
            }

            $event->attendees()->updateExistingPivot($pid, $request->all());

            $this->addActivity($request->header('ID'),'update', $eid, 'event application', $pid);

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete an Attendee of an Event.
     *
     * @param  EventAttendeeRequest  $request
     * @param  int  $eid
     * @param  int  $pid
     * @return Response
     */
    public function destroy(EventAttendeeRequest $request, $eid, $pid)
    {
        try {
            $event = Event::find($eid);
            if (!$event) {
                return response()->error(404, 'Event Not Found');
            }

            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            $vehicles = $event->vehicles()->get();
            foreach ($vehicles as $vehicle) {
                if ($vehicle->passengers()->where('profile_id', $pid)->exists()) {
                    $vehicle->passengers()->detach($profile);
                    $vehicle->decrement('passenger_count');
                }
            }

            $event->attendees()->detach($profile);
            $event->decrement('attendee_count');

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
