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

        //Check If Email Has Correct Regex
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            //TODO - IF Email is not match proper email regex
            return "email";//redirect('fail');
        }

        //Check If Password is correctly set
        if((strlen($password) < 8) ||
            !preg_match("#[0-9]+#", $password) ||
            !preg_match("#[a-zA-Z]+#", $password)){
            //TODO - IF Password is incorrectly set
            return "wrong password";//redirect('fail');
        }

        try{

            //Check if email exists within DB
            $checkUserExist = \Sentinel::findByCredentials(['login' => $email]);
            if($checkUserExist){
                //TODO - The Email ALready Exists.
                return "User already exist";//redirect('fail');
            }

            //Register User to Database
            \Sentinel::register($credential);

            //Check if User has been saved to DB
            $checkUserExist = \Sentinel::findByCredentials(['login' => $email]);
            if(!$checkUserExist){
                //TODO - Check if User has been saved into DB
                return "User has not been saved into DB";//redirect('fail');
            }

            //Put User on Activate Table
            $activation_result = \Activation::create($checkUserExist);

            //Check If User is on the Activation table
            $userActivation = \Sentinel::findById($checkUserExist->id);
            $activationCheck = \Activation::exists($userActivation);
            if(!$activationCheck){
                \DB::table('users')->where('id',$checkUserExist->id)->delete();
                //TODO - Redo the registration
                return "User was not saved into Activation table";//redirect('fail');

            }
            //TODO - Send Email to User with Activation code

            //Registration Successful - TODO - Go to Sucess page
            return \Response::json($checkUserExist->toArray());
        }catch(Exception $e)
        {
            App::abort(404,$e->getMessage());
        }
    }
}

 ?>
