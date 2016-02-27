<?php
namespace App\Http\Controllers;

class verification_controller extends Controller{
    /*
        DEV TEST - VERIFICATION
    */
    function verification_code_check(){
        $code = $_GET['verify'];
        $userID = $_GET['id'];

        $user = \Sentinel::findById($userID);
        if(\Activation::complete($user,$code)){

            //TODO -
            //Activation was Succesfull
            return redirect('success');
        }else{
            //TODO -
            //IT was no found/ Not complete
            return redirect('fail');
        }
    }
}
 ?>
