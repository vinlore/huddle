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
        $activationCode = bcrypt($email.$password);

        $credential = array(
    		'email'     => $email,
    		'password'  => $password,
    		'first_name' => $firstName,
    		'last_name' => $lastName,
    	);
        try{
            //Register User to Database
            $user = \Sentinel::register($credential);

            //Check if User has been saved to DB
            $activateUser = \Sentinel::findById($user->id);

            //Put User on Activate Table
            $activation = \Activation::create($activateUser);

            var_dump($activation->code);
            //Send Email to User with Activation code

            return \Response::json($user->toArray());
        }catch(Exception $e)
        {
            App::abort(404,$e->getMessage());
        }
    }



}

 ?>
