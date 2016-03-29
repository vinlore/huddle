<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Activity;
use App\Models\User;
use App\Models\Profile;
use App\Models\Conference;
use App\Models\Event;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function addActivity($userId, $activityType, $sourceId, $sourceType)
    {
        try {
            $activity = [
                'user_id'       => $userId,
                'activity_type' => $activityType,
                'source_id'     => $sourceId,
                'source_type'   => $sourceType,
            ];
            Activity::create($activity);
        } catch (Exception $e) {
            return $e;
        }
    }



    public function sendAttendeeEmail($type, $id, $status, $profile_id){

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
                Your request to attend '.$name.' has been '.$status.'.';


        \Mail::send([], [], function ($message) use($email,$subject,$body) {
                $message->to($email)
                ->subject($subject)
                ->setBody($body);
        });

    }

    public function sendCreationEmail($type, $id, $status){

         if($type == 'conference'){
            $conference = Conference::where('id',$id)->first();

            $name = $conference->name;

            $users = \DB::table('user_manages_conferences')
                        ->where('conference_id', $conference->id)
                        ->get();


        }else{
            $event = Event::find($id)->first();
            $name = $conference->name;
            $users = \DB::table('user_manages_events')
                        ->where('conference_id', $conference->id)
                        ->get();
        }
        var_dump($users);

        foreach($users as $u){
            $profile = Profile::where('user_id',$u->user_id)->where('is_owner',1)->first();
            $user= User::where('id', $u->user_id)->first();
            if(($user->receive_email == 0) || ($user->email == null)){
                }else{
                $email = $user->email;
                $subject = '"'.$name.'" Creation Request Update';
                $body = 'Hi, '.$profile->first_name.'!
                        Your request to create '.$name.' has been '.$status.'.';

                    \Mail::queue([], [], function ($message) use($email,$subject,$body) {
                        $message->to($email)
                                ->subject($subject)
                                ->setBody($body);
                    });

                }
            }
        }




}
