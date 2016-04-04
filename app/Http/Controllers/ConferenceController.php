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
     * Retrieve all Conferences.
     *
     * @return Collection|Response
     */
    public function index(ConferenceRequest $request)
    {
        try {
            return Conference::all();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create a Conference.
     *
     * @return Response
     */
    public function store(ConferenceRequest $request)
    {
        try {
            $conference = Conference::create($request->all());

            $user = $this->getUser($request);
            $conference->managers()->attach($user->id);

            $this->addActivity($user->id, 'requested', $conference->id, 'conference');

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve a Conference.
     *
     * @return App\Models\Conference|Response
     */
    public function show(Request $request, $cid)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404);
            }

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
    public function update(ConferenceRequest $request, $cid)
    {
        try {
            $user = $this->isConferenceManager($request, $cid);
            if (!$user) {
                return response()->error(403);
            }

            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $activityType = 'updated';

            if ($request->exists('status')) {

                $oldStatus = $conference->status;
                $newStatus = $request->status;

                switch ($newStatus) {
                    case 'approved':
                    case 'denied':
                        if ($oldStatus != 'pending') {
                            break;
                        }
                        $activityType = $newStatus;
                        $this->sendCreationEmail('conference', $cid, $newStatus);
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

            $conference->fill($request->all())->save();

            $this->addActivity($user->id, $activityType, $cid, 'conference');

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete a Conference.
     *
     * @return Response
     */
    public function destroy(ConferenceRequest $request, $cid)
    {
        try {
            $user = $this->isConferenceManager($request, $cid);
            if (!$user) {
                return response()->error(403);
            }

            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $conference->delete();

            $this->addActivity($user->id, 'deleted', $cid, 'conference');

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve all Conferences of a certain status.
     *
     * @return Collection|Response
     */
    public function indexWithStatus(Request $request, $status)
    {
        try {
            return Conference::where('status', $status)->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve all Events of a Conference of a certain status.
     *
     * @return Collection|Response
     */
    public function eventsWithStatus(Request $request, $cid, $status)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            return $conference->events()->where('status', $status)->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
