<?php
namespace App\Http\Controllers;

class create_user_controller extends Controller {
    /*
        DEV TEST - CREATE USER
    */
    function create_user(){
        $email = $_POST['email'];
        $password = $_POST ['password'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];


        $credential = array(
    		'email'     => $email,
    		'password'  => $password,
    		'first_name' => $firstName,
    		'last_name' => $lastName,
    	);
        try{
            $user = \Sentinel::register($credential,true);
            return \Response::json($user->toArray());
        }catch(Exception $e)
        {
            App::abort(404,$e->getMessage());
        }

        var_dump($user);
    }



}

 ?>
