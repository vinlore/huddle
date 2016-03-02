<?php
namespace App\Http\Controllers;

class AuthenticateController extends Controller {

    /*
     * User Creation
     */
    function user_registration(){
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
            return "{'success' : false, 'error':{ 'code' : 'Aphrodite', 'message' : 'Email does not match regex'}}";
        }

        //Check If Password is correctly set
        if((strlen($password) < 8) ||
            !preg_match("#[0-9]+#", $password) ||
            !preg_match("#[a-zA-Z]+#", $password)){
            //TODO - IF Password is incorrectly set
            return "{'success' : false, 'error':{ 'code' : 'Aporia', 'message' : 'Password incorrectly set'}}";
        }

        try{

            //Check if email exists within DB
            $checkUserExist = \Sentinel::findByCredentials(['login' => $email]);
            if($checkUserExist){
                //TODO - The Email ALready Exists.
                return "{'success' : false, 'error':{ 'code' : 'Ares', 'message' : 'Email already exists'}}";
            }

            //Register User to Database
            \Sentinel::register($credential);

            //Check if User has been saved to DB
            $checkUserExist = \Sentinel::findByCredentials(['login' => $email]);
            if(!$checkUserExist){
                //TODO - Check if User has been saved into DB
                return "{'success' : false, 'error':{ 'code' : 'Artemis', 'message' : 'User unable to save to Database'}}";
            }

            //Put User on Activate Table
            $activation_result = \Activation::create($checkUserExist);

            //Check If User is on the Activation table
            $userActivation = \Sentinel::findById($checkUserExist->id);
            $activationCheck = \Activation::exists($userActivation);
            if(!$activationCheck){
                \DB::table('users')->where('id',$checkUserExist->id)->delete();
                //TODO - User not saved into activation table - Redo the registration
                return "{'success' : false, 'error':{ 'code' : 'Atlas', 'message' : 'User not saved into activation table'}}";
            }
            //TODO - Send Email to User with Activation code

            //Registration Successful - TODO - Go to Sucess page
            return \Response::json($checkUserExist->toArray());
        }catch(Exception $e){
            App::abort(404,$e->getMessage());
        }
    }

    /*
    *  Activation of user account
    */
    function user_activation(){
        $code = $_GET['a'];
        $userID = $_GET['id'];

        $user = \Sentinel::findById($userID);
        if(\Activation::complete($user,$code)){
            //TODO -
            //Activation was Succesfull
            return "{'success' : true}";
        }else{
            //TODO -
            //IT was no found/ Not complete
            return "{'success' : false, 'error':{ 'code' : 'Athena', 'message' : 'Activation not complete'}}";
        }
    }

    /*
    *   Authenticate the User when logging in
    */
    function user_authentication(){

        $email = $_POST['email'];
        $password = $_POST ['password'];

        $credential = array(
            'email'     => $email,
            'password'  => $password,
        );
        try{
            //Check if User Exists within Database
            if(!$user = \Sentinel::findByCredentials(['login' => $email])){
                //TODO - This User does not exist
                return "{'success' : false, 'error':{ 'code' : 'Aura', 'message' : 'User Does Not Exist'}}";
            }

            //Authenicate Users login and password
            if(!$user = \Sentinel::authenticateAndRemember($credential,true)){
                //TODO - What happens if login information is incorrect
                return "{'success' : false, 'error' : { 'code' : 'Adikia', 'message' : 'Login Information Incorrect'}}";
            }

            //generate login token
            $token = bcrypt($user);
            $user->api_token = $token;

            //save token to database
            \DB::table('users')->where('email',$email)->update(['api_token' => $token]);

            //Generate JSON to return
            return \Response::json(array('token' => $token, 'user' => $user->toArray()));
        }catch(\Cartalyst\Sentinel\Checkpoints\ThrottlingException $e){
            return "{'success' : false, 'error' : { 'code' : 'Acratopotes', 'message' : 'Too many login attempts'}}";
        }catch(\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e){
            return "{'success' : false, 'error' : { 'code' : 'Adephagia', 'message' : 'Activation not complete'}}";
        }catch(Exception $e)
        {
            App::abort(404,$e->getMessage());
        }
    }
}



?>
