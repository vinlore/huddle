<?php	
use App\Models\User as User;
  function userCheck($id, $api_key){

   		$user_id = $id;
   		$api_token = $api_key;

   	   // $user = \Sentinel::findById($user_id);
        $user_to_check = User::find($user_id);

        if($user_to_check->api_token == $api_token){

            $response = true;

        }else{

            $response = false;

        }

        return $response;

   }

   ?>