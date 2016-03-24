<?php
use App\Models\User as User;
  function userCheck($id, $api_key){
   	   // $user = \Sentinel::findById($user_id);
        $user_to_check = User::find($id);
        if($user_to_check->api_token == $api_key)
            return true;
        else
            return false;
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
