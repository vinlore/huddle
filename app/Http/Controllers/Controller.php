<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Sentinel;

use App\Models\Activity;
use App\Models\User;
use App\Models\Profile;
use App\Models\Conference;
use App\Models\Event;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Retrieve the authenticated User.
     *
     * @return App\Models\User|bool
     */
    public function getUser($request)
    {
        $userId = $request->header('ID');
        $apiToken = $request->header('X-Auth-Token');
        $user = Sentinel::findById($userId);
        if ($user->api_token == $apiToken) {
            return $user;
        }
        return false;
    }

    /**
     * Check if the User is a System Administrator.
     *
     * @return bool
     */
    public function isSuperuser($request)
    {
        $user = $this->getUser($request);
        $role = $user->roles()->first();
        return $role->name == 'System Administrator';
    }

    /**
     * Check if the User manages the given Conference.
     * Also return true if the User is a System Administrator.
     *
     * @return bool
     */
    public function isConferenceManager($request, $cid)
    {
        $user = $this->getUser($request);
        $conference = Conference::find($cid);
        $isConferenceManager = $conference->managers()->where('user_id', $user->id)->exists();
        return $this->isSuperuser($request) || $isConferenceManager;
    }

    /**
     * Check if the User manages the given Event.
     * Also return true if the User manages the parent Conference.
     * Also return true if the User is a System Administrator
     *
     * @return bool
     */
    public function isEventManager($request, $eid)
    {
        $user = $this->getUser($request);
        $event = Event::find($eid);
        $isEventManager = $event->managers()->where('user_id', $user->id)->exists();
        return $this->isSuperUser($request) || $this->isConferenceManager($request, $event->conference->id) || $isEventManager;
    }


    public function addActivity($userId, $activityType, $sourceId, $sourceType, $profile_id = null)
    {
        try {
            $activity = [
                'user_id'       => $userId,
                'activity_type' => $activityType,
                'source_id'     => $sourceId,
                'source_type'   => $sourceType,
                'profile_id'    => $profile_id
            ];
            Activity::create($activity);
        } catch (Exception $e) {
            return $e;
        }
    }



    public function sendAttendeeEmail($type, $id, $status, $profile_id){

        try{

        $profile = Profile::where('id', $profile_id)->first();
        $user = User::where('id', $profile->user_id)->first();

         if(($user->receive_email == 0) || ($user->email == null) || ($profile->is_owner == 0)){
           return;
        }

        if($type == 'conference'){
            $name = Conference::find($id)->name;
        }else{
            $name = Event::find($id)->name;
        }

        $first_name = $profile->first_name;
        $email = $user->email;

        $subject = '"'.$name.'" Attendance Request Update';
        $body = 'Hi, '.$first_name.'!
        Your request to attend the '.$type.' "'.$name.'"" has been '.$status.'.';


        \Mail::send([], [], function ($message) use($email,$subject,$body) {
                $message->to($email)
                ->subject($subject)
                ->setBody($body);
        });

        }catch(Exception $e){
            return $e;
        }

    }

    public function sendCreationEmail($type, $id, $status){

        try{

         if($type == 'conference'){
            $conference = Conference::where('id',$id)->first();
            $name = $conference->name;
            $managers = $conference->managers()->get();
        }else{
            $event = Event::find($id)->first();
            $name = $event->name;
            $managers = $event->managers()->get();
        }

        if(!$managers){
          return;
        }

        foreach($managers as $manager){

            $profile = Profile::where('user_id',$manager->id)->where('is_owner',1)->first();
            $user= User::where('id', $manager->id)->first();

            if(($user->receive_email == 0) || ($user->email == null)){
                }else{
                $email = $user->email;
                $subject = '"'.$name.'" Creation Request Update';
                $body = 'Hi, '.$profile->first_name.'!
                Your request to create the '.$type.' "'.$name.'"" has been '.$status.'.';

                    \Mail::queue([], [], function ($message) use($email,$subject,$body) {
                        $message->to($email)
                                ->subject($subject)
                                ->setBody($body);
                    });

                }
            }

          }catch(Exception $e){
            return $e;
          }
        }




}
