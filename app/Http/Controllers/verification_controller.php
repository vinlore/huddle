<?php
namespace App\Http\Controllers;

class verification_controller extends Controller{
    /*
        DEV TEST - VERIFICATION
    */
    function verification_code_check(){
        var_dump("Able to load the page");
        $code = $_GET['verify'];

        var_dump("activation :".$code);
        $userID = \DB::table('users')
                        ->where('activationCode',$code)
                        ->pluck('id');
        $userID = $userID[0];
        var_dump("Plucked matching User ID:".$userID);
        if($userID == NULL)
        {
            //TODO: redirect to fail to verify
        }else{
            $sentinelUsers = \Sentinel::findById($userID);
            var_dump("Able to find User");
            $activation = \Activation::create($sentinelUsers);
            var_dump("Able to activate User");
        }
    }
}
 ?>
