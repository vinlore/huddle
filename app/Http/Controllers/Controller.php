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
     * Check if the given User is a System Administrator.
     *
     * @return bool
     */
    public function isSuperuser($request)
    {
        $userId = $request->header('ID');
        $user = Sentinel::findById($userId);
        $role = $user->roles()->first();
        return $role->name == 'System Administrator';
    }

    /**
     * Check if the User manages the given Conference.
     *
     * @return bool
     */
    public function isConferenceManager($request, $cid)
    {
        $userId = $request->header('ID');
        $user = Sentinel::findById($userId);
        $conference = Conference::find($cid);
        if ($this->isSuperUser($request)) {
            return true;
        }
        return $conference->managers()->where('user_id', $userId)->exists();
    }

    /**
     * Check if the User manages the given Event.
     *
     * @return bool
     */
    public function isEventManager($request, $eid)
    {
        $userId = $request->header('ID');
        $user = Sentinel::findById($userId);
        $event = Event::find($eid);
        if ($this->isSuperUser($request)) {
            return true;
        }
        return $event->managers()->where('user_id', $userId)->exists();
    }

    public function addActivity($userId, $activityType, $sourceId, $sourceType, $profile_id)
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
            $name = $conference->name;
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
