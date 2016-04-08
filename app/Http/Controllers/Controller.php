<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Mail;
use Sentinel;

use App\Models\Activity;
use App\Models\Conference;
use App\Models\Event;
use App\Models\Profile;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // -------------------------------------------------------------------------
    // AUTHENTICATION
    // -------------------------------------------------------------------------

    /**
     * Retrieve the authenticated User.
     *
     * @param  Request  $request
     * @return App\Models\User|bool
     */
    public function getUser($request)
    {
        $uid = $request->header('ID');
        $token = $request->header('X-Auth-Token');
        $user = Sentinel::findById($uid);
        if ($user->api_token == $token) {
            return $user;
        }
        return false;
    }

    /**
     * Check if the User is a System Administrator.
     *
     * @param  Request  $request
     * @return bool
     */
    public function isSuperuser($request)
    {
        $user = $this->getUser($request);
        $role = $user->roles()->first();
        return $role->name == 'System Administrator';
    }

    /**
     * Check if the User:
     * - manages the given Conference or
     * - is a System Administrator.
     *
     * @param  Request  $request
     * @param  int  $cid
     * @return App\Models\User|bool
     */
    public function isConferenceManager($request, $cid)
    {
        $user = $this->getUser($request);
        $conference = Conference::find($cid);
        $isConferenceManager = $conference->managers()->where('user_id', $user->getKey())->exists();
        if ($this->isSuperuser($request) || $isConferenceManager) {
            return $user;
        }
        return false;
    }

    /**
     * Check if the User:
     * - manages the given Event,
     * - manages the parent Conference, or
     * - is a System Administrator.
     *
     * @param  Request  $request
     * @param  int  $eid
     * @return App\Models\User|bool
     */
    public function isEventManager($request, $eid)
    {
        $user = $this->getUser($request);
        $event = Event::find($eid);
        $isEventManager = $event->managers()->where('user_id', $user->getKey())->exists();
        if ($this->isSuperUser($request) || $this->isConferenceManager($request, $event->conference->getKey()) || $isEventManager) {
            return $user;
        }
        return false;
    }

    // -------------------------------------------------------------------------
    // ACTIVITY LOG
    // -------------------------------------------------------------------------

    /**
     * Create an Activity.
     *
     * @param  int  $uid
     * @param  string  $activityType
     * @param  int  $sourceId
     * @param  string  $sourceType
     * @param  int  $pid
     * @return void
     * @throws Exception
     */
    public function addActivity($uid, $activityType, $sourceId, $sourceType, $pid = NULL)
    {
        try {
            $activity = [
                'user_id'       => $uid,
                'activity_type' => $activityType,
                'source_id'     => $sourceId,
                'source_type'   => $sourceType,
                'profile_id'    => $pid,
            ];
            Activity::create($activity);
        } catch (Exception $e) {
            throw $e;
        }
    }

    // -------------------------------------------------------------------------
    // EMAIL
    // -------------------------------------------------------------------------

    /**
     * Email the Managers of a Conference about an update.
     *
     * @param  int  $cid
     * @param  string  $status
     * @return void
     * @throws Exception
     */
    public function sendConferenceRequestEmail($cid, $status)
    {
        try {
            $conference = Conference::find($cid);
            $conferenceName = $conference->name;
            $managers = $conference->managers()->get();

            foreach ($managers as $manager) {
                $user = Sentinel::findById($manager->getKey());
                $email = $user->email;
                $name =  $user->profiles()->where('is_owner', 1)->first()->first_name;

                if ($email && $user->receive_email) {
                    $subject = '[Huddle] Update to Your Conference Creation Request for ' . $conferenceName;
                    $body = 'Hi, ' . $name . '!' . "\n\n" .
                            'Your request to create the conference ' . $conferenceName .
                            ' has been ' . $status . '.';

                    Mail::queue([], [], function ($message) use($email, $subject, $body) {
                        $message->to($email)
                                ->subject($subject)
                                ->setBody($body);
                    });
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Email the Managers of an Event about an update.
     *
     * @param  int  $eid
     * @param  string  $status
     * @return void
     * @throws Exception
     */
    public function sendEventRequestEmail($eid, $status)
    {
        try {
            $event = Event::find($eid);
            $eventName = $event->name;
            $managers = $event->managers()->get();

            foreach ($managers as $manager) {
                $user = Sentinel::findById($manager->getKey());
                $email = $user->email;
                $name =  $user->profiles()->where('is_owner', 1)->first()->first_name;

                if ($email && $user->receive_email) {
                    $subject = '[Huddle] Update to Your Event Creation Request for ' . $eventName;
                    $body = 'Hi, ' . $name . '!' . "\n\n" .
                            'Your request to create the event ' . $eventName .
                            ' has been ' . $status . '.';

                    Mail::queue([], [], function ($message) use($email, $subject, $body) {
                        $message->to($email)
                                ->subject($subject)
                                ->setBody($body);
                    });
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Email a Conference Attendee about an update to their application.
     *
     * @param  int  $cid
     * @param  int  $pid
     * @param  string  $status
     * @return void
     * @throws Exception
     */
    public function sendConferenceSignupEmail($cid, $pid, $status)
    {
        try {
            $conference = Conference::find($cid);
            $conferenceName = $conference->name;

            $profile = Profile::find($pid);
            $user = $profile->user()->first();
            $email = $user->email;
            $name =  $profile->first_name;

            if ($email && $user->receive_email && $profile->is_owner) {
                $subject = '[Huddle] Update to Your Conference Attendance Request for ' . $conferenceName;
                $body = 'Hi, ' . $name . '!' . "\n\n" .
                        'Your request to attend the conference ' . $conferenceName .
                        ' has been ' . $status . '.';

                Mail::queue([], [], function ($message) use($email, $subject, $body) {
                    $message->to($email)
                            ->subject($subject)
                            ->setBody($body);
                });
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Email an Event Attendee about an update to their application.
     *
     * @param  int  $eid
     * @param  int  $pid
     * @param  string  $status
     * @return void
     * @throws Exception
     */
    public function sendEventSignupEmail($eid, $pid, $status)
    {
        try {
            $event = Event::find($eid);
            $eventName = $event->name;

            $profile = Profile::find($pid);
            $user = $profile->user()->first();
            $email = $user->email;
            $name =  $profile->first_name;

            if ($email && $user->receive_email && $profile->is_owner) {
                $subject = '[Huddle] Update to Your Event Attendance Request for ' . $eventName;
                $body = 'Hi, ' . $name . '!' . "\n\n" .
                        'Your request to attend the event ' . $eventName .
                        ' has been ' . $status . '.';

                Mail::queue([], [], function ($message) use($email, $subject, $body) {
                    $message->to($email)
                            ->subject($subject)
                            ->setBody($body);
                });
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}
