<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cartalyst\Sentinel\Roles\EloquentRole;
use App\Http\Requests;
use App\Models\User;


class RoleController extends Controller
{
    /**
     * Display a listing of Roles

     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EloquentRole::all();
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

        //Check for permissions - role.store

        $user_id = User::where('api_token', $request->header('X-Auth-Token'))->first();
        $user = \Sentinel::findById($user_id->id);

        if (!$user->hasAccess(['role.store'])){
            return \Response::json(array(
                'status' => 'error',
                'code' => 'Role Permissions',
                'message' => 'You have no permissions to access this'
            ));
        }

        $slug = strtolower($request->name);
        $name = $request->name;

        if (\Sentinel::findRoleBySlug($slug) || \Sentinel::findRoleByName($name)) {
            return \Response::json(array(
                'status' => 'error',
                'code' => 'Role Permissions',
                'message' => 'Role name already exists'
            ));
        }

        $role = \Sentinel::getRoleRepository()->createModel()->create([
                'name' => $request->name,
                'slug' => strtolower($request->name),
                'permissions' => json_decode(json_encode($request->permissions), true)
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

         //Check for permissions - role.update
         $user_id = User::where('api_token',$response->api_token)->first();
         $user = Sentinel::findById($user_id->id);
         if (!$user->hasAccess(['role.update'])){
             return \Response::json(array(
                 'status' => 'error',
                 'code' => 'Role Permissions',
                 'message' => 'You have no permissions to access this'
             ));
         }

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
     * Destroy the Role from role table
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        /* EXAMPLE OF JSON REQUEST
        $request =json_encode(array(
             'user_id' =>  4,
             'role_id' => 1,
         ));

         $response = json_decode($request);
         */

        //Check if Role Id exists
        if(!\Sentinel::findRoleById($response->role_id))
        {
            return \Response::json(array(
                'status' => 'error',
                'code' => 'Remus',
                'message' => 'Unable to find Role with role_id '.$response->role_id
            ));
        }

        //Check if Users have this role_id
        $role = Sentinel::findRoleById($response->role_id);
        if($role->users()->with('roles')->get())
        {
            return \Response::json(array(
                'status' => 'error',
                'code' => 'Roma',
                'message' => 'Users are assigned to this role, unable to delete role, Make sure to remove this role from all Users',
            ));
        }
        //Destroy Role
        Sentinel::findRoleById($response->role_id)->delete();
    }

}
