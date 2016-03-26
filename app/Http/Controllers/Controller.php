<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Activity as Activity;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
}
