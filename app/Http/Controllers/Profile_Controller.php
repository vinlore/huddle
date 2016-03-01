<?php
namespace App\Http\Controllers;

class Profile_Controller extends Controller {

    //Returns user profile
    function get_profile () {

    }

    //Update Profile
    function update_profile () {

    }

    //Update permissions
    function update_permissions () {

    }

    //Delete user
    function delete_user () {

    }

    //Deactivate user
    function deactivate_user () {
        $user = Sentinel::findById($_PUT['id']);

        if(\Activation::remove($user);){
            return "{ 'success' : true }";
        }else{
            return "{ 'success' : false , 'error' : { 'code' : 'Paeon', 'message' : 'User activation record not found'}}";
        }

    }
}
?>
