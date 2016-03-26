<?php
use App\Models\User as User;
use App\Models\Activity as Activity;

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
