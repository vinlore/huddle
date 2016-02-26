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
            $user = \Sentinel::register($credential);
            $checkID = \DB::table('users')->where('email',$email)->pluck('id');
            $checkID = $checkID[0];
            var_dump("User Exists: ".$checkID);
            if($checkID == NULL)
            {
                var_dump("Something went wrong with the registration");
                //TODO When registering user fails
            }else{
                    var_dump("This user id: ".$checkID);
                    var_dump("This is the email: ".$email);
                    \DB::table('users')->where('id',$checkID)
                                        ->where('email',$email)
                                        ->update(["activationCode" => $activationCode]);
                    var_dump("Able to Update Activation code");
                //TODO Sending email
                /*Mail::raw('Text to e-mail', function($message)
                {
                    $message->from('evilpranks@gmail.com', 'Laravel');

                    $message->to('m4rtin.t@gmail.com');
                });
                */
            }
            return \Response::json($user->toArray());
        }catch(Exception $e)
        {
            App::abort(404,$e->getMessage());
        }
    }



}

 ?>
