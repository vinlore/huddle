<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as User;
use App\Models\Profile as Profile;

class AuthController extends Controller
{

    /*
     * User Creation
     */
    function register(Request $request){

        $username = $request->username;
        $email = $request->email;
        $password = $request->password;
        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $middleName = $request->middleName;
        $birthdate = $request->birthdate;
        $country = $request->country;
        $city = $request->city;
        $phone = $request->phone;
        $gender = $request->gender;

        $user_credential = array(
            'username' => $username,
            'email'     => $email,
            'password'  => $password,
            'role_id'   => 1
        );


        //Check If username is correctly set
        if((strlen($username) < 4) ||
            !preg_match('/^[a-zA-Z0-9]+[_.-]{0,1}[a-zA-Z0-9]+$/m', $username)){
            return \Response::json(array(
                'status' => 'error',
                'code' => 'Aporia',
                'message' => 'Username incorrectly set'
            ));
        }

        //Check if username exists within DB
        $checkUserExist = \Sentinel::findByCredentials(['login' => $username]);
        if($checkUserExist){
            return \Response::json(array(
                'status' => 'error',
                'code' => 'Ares',
                'message' => 'Username already exists'
            ));
        }

        //Check If Password is correctly set
        if((strlen($password) < 8) ||
            !preg_match("#[0-9]+#", $password) ||
            !preg_match("#[a-zA-Z]+#", $password)){
            return \Response::json(array(
                'status' => 'error',
                'code' => 'Aporia',
                'message' => 'Password incorrectly set'
            ));
        }

        //Check if email exists within DB
        if($email) {
            $checkUserExist = \DB::table('users')->where('email',$email)->get();
            if($checkUserExist){
                //TODO - The Email ALready Exists.
                return \Response::json(array(
                    'status' => 'error',
                    'code' => 'Aegaeon',
                    'message' => 'Email already exists'
                ));
            }

            //Check If Email Has Correct Regex
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                return \Response::json(array(
                    'status' => 'error',
                    'code' => 'Aphrodite',
                    'message' => 'Email does not match regex'
                ));
            }
        }

        try{
            //Register User to Database
            \Sentinel::register($user_credential,true);

            /*if(!empty($email)){
                //Send Email to User saying they are registered
                \Mail::send('email',['email' => $email] , function($message) use($email){
                    $message->to($email)->subject('You have been registered, Welcome to Huddle!');
                });
            }*/

            $user = \Sentinel::findByCredentials(['login' => $username]);

            //Create and link a profile to user
            $user_id = $user->id;

            $profile = new Profile;
            $profile->user_id =  $user_id;
            $profile->first_name = $firstName;
            $profile->middle_name = $middleName;
            $profile->last_name = $lastName;
            $profile->city = $city;
            $profile->country = $country;
            $profile->birthdate = $birthdate;
            $profile->gender = $gender;
            $profile->email = $email;
            $profile->phone = $phone;
            $profile->is_owner = 1;
            //TODO: add validation check birthdate 'YYYY-MM-DD', phone all #s, email, other stuff only letters not crazy long
            //      required: first_name, last_name, birthdate, gender
            $profile->save();

            // Login
            if(!$user = \Sentinel::authenticateAndRemember($user_credential,true)){
                return \Response::json(array(
                    'status' => 'error'
                ));
            }

            $token = bcrypt($user);
            $user->api_token = $token;

            \DB::table('users')->where('username',$username)->update(['api_token' => $token]);

            $user->first_name = $firstName;

            return \Response::json(array(
                'status' => 'success',
                'token' => $token,
                'user' => $user
            ));

        } catch(Exception $e) {
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
    function login(Request $request){

        $username = $request->username;
        $password = $request->password;

        $credential = array(
            'username'  => $username,
            'password'  => $password,
        );
        try{
            //Check if User Exists within Database
            if(!$user = \Sentinel::findByCredentials(['login' => $username])){
                // This User does not exist
                return \Response::json(array(
                    'status' => 'error',
                    'code' => 'Aura',
                    'message' => 'User Does Not Exist'
                ));
            }

            //Authenicate Users login and password
            if(!$user = \Sentinel::authenticateAndRemember($credential,true)){
                // What happens if login information is incorrect
                return \Response::json(array(
                    'status' => 'error',
                    'code' => 'Adikia',
                    'message' => 'Login Information Incorrect'
                ));
            }

            //generate login token
            $token = bcrypt($user);
            $user->api_token = $token;

            //save token to database
            \DB::table('users')->where('username',$username)->update(['api_token' => $token]);

            //Generate JSON to return
            return \Response::json(array('token' => $token, 'user' => $user->toArray()));

        } catch(\Cartalyst\Sentinel\Checkpoints\ThrottlingException $e) {
            return \Response::json(array('status' => 'error', 'code' => 'Acratopotes', 'message' => 'Too many login attempts'));

        } catch(\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) {
            return \Response::json(array('status' => 'error', 'code' => 'Adephagia', 'message' => 'Activation not complete'));

        } catch(Exception $e) {
            App::abort(404,$e->getMessage());
        }
    }

    /*
    *   User logout
    */
    function logout(Request $request) {
        $api_token = $request->token;

        $checkTokenExist = \DB::table('users')->where('api_token', $api_token)->get();
        if ($checkTokenExist) {
            \DB::table('users')->where('api_token', $api_token)->update(['api_token' => '']);
            return \Response::json(array('status' => 'success'));
        } else {
            // Should never get to this condition
            return \Response::json(array(
                'status' => 'error',
                'message' => 'Token not found'
            ));
        }
    }
}
