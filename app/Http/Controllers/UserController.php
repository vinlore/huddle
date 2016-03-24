<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\User;

require app_path().'/helpers.php';

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = \Sentinel::getUserRepository()->with('roles')->get();
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * Update the user's permissions and Role with the request state of their permissions and Roles.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $users)
    {
        /* Example JSON of request
        *
        $request =json_encode(array(
             'api_token' => 1,
             'user_id' =>  7,
             'permissions' => array(
                 'model.update' => true,
                 'model.view' => true,
             ),
             'role_id' => 1,
         ));
         $request = json_decode($request);
         */

         //Check if Role Id exists
         if(!\Sentinel::findRoleById($request->role_id))
         {
             return \Response::json(array(
                 'status' => 'error',
                 'code' => 'Unta',
                 'message' => 'Unable to find Role with role_id '.$request->role_id
             ));
         }

         //Check if User Id Exists
         if(!\Sentinel::findUserById($users))
         {
             return \Response::json(array(
                 'status' => 'error',
                 'code' => 'Umesh',
                 'message' => 'Unable to find User with user_id '.$users
             ));
         }

         //Update Role first
         $user = \Sentinel::findById($users);
         $role = \Sentinel::findRoleById($request->role_id);

         $user->roles()->sync([$role->id]);

         //Update Permissions next
         $user->permissions = json_decode(json_encode($request->permissions), True);
         $user->save();

        return \Response::json(array(
            'status' => 'success'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
