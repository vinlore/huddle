<?php
namespace App\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

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
            //Check if User Exists within Database
            if(!$user = \Sentinel::findByCredentials(['login' => $email])){
                return "User Does not Exist";
            }

            //Check If User has been activated
            if (!$activation = \Activation::completed($user)){
                //TODO - Activation not found or not completed
                return "Activation is not complete";
            }

            //Authenicate Users login and password
            if(!$user = \Sentinel::authenticateAndRemember($credential,true)){
                //TODO - What happens if login information is incorrect
                return "Login is incorrect";
            }

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
