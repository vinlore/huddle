<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Accommodation as Accommodation;

use App\Models\User;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* SAMPLE JSON BEING SENT
        $request =json_encode(array(
             'api_token' =>  123,
             'name' => 'Admin'
         ));
        $response =json_decode($request);
        */

        $role = \Sentinel::getRoleRepository()->createModel()->create([
                'name' => $request->name,
                'slug' => strtolower($name),
            ]);

        return $role;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Update the specified resource in storage.
     * Update the permissions of a role
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* EXAMPLE OF JSON REQUEST
        $request =json_encode(array(
             'id' =>  4,
             'permissions' => array(
                 'user.update' => true,
                 'user.view' => true,
             ),
         ));

         $response = json_decode($request);
         */

         //Check if Role Id exists
         if(!\Sentinel::findRoleById($response->role_id))
         {
             return \Response::json(array(
                 'status' => 'error',
                 'code' => 'Remi',
                 'message' => 'Unable to find Role with role_id '.$response->role_id
             ));
         }

        $role = \Sentinel::findRoleById($response->id);

         //Convert into String, then back into array
         //Place array into the roles permissions
         $role->permissions = json_decode(json_encode($response->permissions), True);
         $role->save();

         return $role;
    }


    /**
     * Remove the specified resource from storage.
     * Destroy the Role
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Check if Role Id exists
        if(!\Sentinel::findRoleById($id))
        {
            return \Response::json(array(
                'status' => 'error',
                'code' => 'Remus',
                'message' => 'Unable to find Role with role_id '.$id
            ));
        }

        //Check if Users have this user_id
        if(User::where('role_id',$id)->first())
        {
            return \Response::json(array(
                'status' => 'error',
                'code' => 'Roma',
                'message' => 'Users are assigned to this role, unable to delete role, Make sure to remove this role from all Users',
            ));
        }
        //Destroy Role
        Role::destroy($id);
    }

}
