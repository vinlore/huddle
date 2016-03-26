<?php
use App\Models\User as User;
use App\Models\Activity as Activity;
  function addActivity($user_id, $activity_type, $source_id, $source_type){
   	   try{
          $activity = [    
                        'user_id'           => $user_id,
                        'activity_type'     => $activity_type,
                        'source_id'         => $source_id,
                        'source_type'       => $source_type
             ];

            Activity::create($activity);

       }catch(Exception $e) {
            return $e;
       }
   }

   /*
   *Input - Authentication Token, Array of permissions e.g.['user.store']
   *Output - Boolean
   */
 function checkPermission($AuthToken,$permissionArray)
   {
       $user_id = User::where('api_token', $AuthToken)->first();
       $user = \Sentinel::findById($user_id->id);

       if($user->hasAccess($permissionArray))
            return true;
       else
            return false;
  }

   ?>
