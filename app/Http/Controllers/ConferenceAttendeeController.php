<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Sentinel;

use App\Http\Requests\ConferenceAttendeeRequest;

use App\Models\Conference;
use App\Models\Profile;

class ConferenceAttendeeController extends Controller
{
    /**
     * Retrieve all Attendees of a Conference.
     *
     * @param  ConferenceAttendeeRequest  $request
     * @param  int  $cid
     * @return Collection|Response
     */
    public function index(ConferenceAttendeeRequest $request, $cid)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            return $conference->attendees()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create an Attendee for a Conference.
     *
     * @param  ConferenceAttendeeRequest  $request
     * @param  int  $cid
     * @return Response
     */
    public function store(ConferenceAttendeeRequest $request, $cid)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $pid = $request->profile_id;
            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            $uid = $request->header('ID');
            $profileOwner = $profile->user()->first()->getKey();
            if ($uid != $profileOwner) {
                return response()->error(403);
            }

            if ($conference->attendee_count >= $conference->capacity) {
                return response()->error(422, 'Exceed Capacity Error');
            }

            $activityType = 'requested';

            $conference->attendees()->attach($profile, $request->except('profile_id'));

            $this->addActivity($uid, $activityType, $cid, 'conference application', $pid);

            return response()->success();
        } catch (Exception $e) {
            return response()->error($e);
        }
    }

    /**
     * Retrieve an Attendee of a Conference.
     *
     * @param  ConferenceAttendeeRequest  $request
     * @param  int  $cid
     * @param  int  $pid
     * @return App\Models\Profile|Response
     */
    public function show(ConferenceAttendeeRequest $request, $cid, $pid)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            return $conference->attendees()->where('profile_id', $pid)->first();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update an Attendee of a Conference.
     *
     * @param  ConferenceAttendeeRequest  $request
     * @param  int  $cid
     * @param  int  $pid
     * @return Response
     */
    public function update(ConferenceAttendeeRequest $request, $cid, $pid)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            $uid = $request->header('ID');
            $profileOwner = $profile->user()->first()->getKey();
            if ($uid != $profileOwner) {
                if (!$this->isConferenceManager($request, $cid)) {
                    return response()->error(403);
                }
            }

            $activityType = 'updated';

            if ($request->exists('status')) {

                $oldStatus = $conference->attendees()->where('profile_id', $pid)->first()->pivot->status;
                $newStatus = $request->status;

                switch ($newStatus) {
                    case 'approved':
                        if ($oldStatus != 'pending') {
                            break;
                        }
                        $activityType = $newStatus;
                        $conference->increment('attendee_count');
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

            $conference->attendees()->updateExistingPivot($pid, $request->all());

            $this->addActivity($uid, $activityType, $cid, 'conference application', $pid);

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete an Attendee of a Conference.
     *
     * @param  ConferenceAttendeeRequest  $request
     * @param  int  $cid
     * @param  int  $pid
     * @return Response
     */
    public function destroy(ConferenceAttendeeRequest $request, $cid, $pid)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $profile = Profile::find($pid);
            if (!$profile) {
                return response()->error(404, 'Profile Not Found');
            }

            $eventVehicles = $conference->eventVehicles()->get();
            foreach ($eventVehicles as $eventVehicle) {
                if ($eventVehicle->passengers()->where('profile_id', $pid)->exists()) {
                    $eventVehicle->passengers()->detach($profile);
                    $eventVehicle->decrement('passenger_count');
                }
            }

            $events = $conference->events()->get();
            foreach ($events as $event) {
                if ($event->attendees()->where('profile_id', $pid)->exists()) {
                    $event->attendees()->detach($profile);
                    $event->decrement('attendee_count');
                }
            }

            $conferenceVehicles = $conference->vehicles()->get();
            foreach ($conferenceVehicles as $conferenceVehicle) {
                if ($conferenceVehicle->passengers()->where('profile_id', $pid)->exists()) {
                    $conferenceVehicle->passengers()->detach($profile);
                    $conferenceVehicle->decrement('passenger_count');
                }
            }

            $rooms = $conference->rooms()->get();
            foreach ($rooms as $room) {
                if ($room->guests()->where('profile_id', $pid)->exists()) {
                    $room->guests()->detach($profile);
                    $room->decrement('guest_count');
                }
            }

            $conference->attendees()->detach($profile);
            $conference->decrement('attendee_count');

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
