<?php
namespace App\Http\Controllers;

class authenticate_user_controller extends Controller {
    /*
        DEV TEST - CREATE USER
    */
    function authenticate_user(){

        $email = $_POST['email'];
        $password = $_POST ['password'];

        $credential = array(
    		'email'     => $email,
    		'password'  => $password,
    	);
        try{
            //authenticate
            $user = \Sentinel::authenticate($credential,false);

            //generate login token
            $token = bcrypt($user);
            $user->api_token = $token;

            //save token to database
            \DB::table('users')->where('email',$email)->update(['api_token' => $token]);

            //Generate JSON to return
            return \Response::json(array('token' => $token, 'user' => $user->toArray()));
        }catch(Exception $e)
        {
            App::abort(404,$e->getMessage());
        }
    }
}

 ?>
