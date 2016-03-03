<?php

namespace App\Http\Controllers;

class ProfileController extends Controller
{
    // -------------------------------------------------------------------------
    // PROFILE
    // -------------------------------------------------------------------------

    function getProfile() {}

    function createProfile() {}

    function updateProfile() {}

    function deleteProfile() {}

    // -------------------------------------------------------------------------
    // USER
    // -------------------------------------------------------------------------

    function updatePermissions() {}

    function deleteUser() {}

    /**
     * Deactivates a user.
     */
    function deactivateUser()
    {
        $user = Sentinel::findById($_PUT['id']);

        if (\Activation::remove($user)) {
            return "{ 'success' : true }";
        } else {
            return "{ 'success' : false , 'error' : { 'code' : 'Paeon', 'message' : 'User activation record not found'}}";
        }
    }
}
