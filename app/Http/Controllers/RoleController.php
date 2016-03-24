<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Cartalyst\Sentinel\Roles\EloquentRole;

use App\Http\Requests;
use App\Models\User;

class RoleController extends Controller
{
    /**
     * Display a listing of Roles

     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $role = EloquentRole::all();
            if (!$role) {
                return response()->success("Rabbit" , "No Roles Found");
            }
            return $role;
        } catch (Exception $e) {
            return response()->error("Rheia" , $e);
        }
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

        $slug = strtolower($request->name);
        $name = $request->name;

        if (\Sentinel::findRoleBySlug($slug) || \Sentinel::findRoleByName($name)) {
            return response()->error("Rhea", "Role name already exists");
        }

        $role = \Sentinel::getRoleRepository()->createModel()->create([
                'name' => $request->name,
                'slug' => strtolower($request->name),
                'permissions' => json_decode(json_encode($request->permissions), true)
            ]);

        return response()->success();
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

         //Check if Role Id exists
         if (!\Sentinel::findRoleById($request->role_id)) {
             return response()->error("Remi" , "Unable to find Role with role_id ".$request->role_id);
         }

         $role = \Sentinel::findRoleById($request->id);

         //Convert into String, then back into array
         //Place array into the roles permissions
         $role->permissions = json_decode(json_encode($request->permissions), True);
         $role->save();

         return response()->success();
    }


    /**
     * Destroy the Role from role table
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $roles)
    {
        /* EXAMPLE OF JSON REQUEST
        $request =json_encode(array(
             'user_id' =>  4,
             'role_id' => 1,
         ));

         $response = json_decode($request);
         */

        //Check if Role Id exists
        if (!\Sentinel::findRoleById($roles)) {
            return response()->error("Remus" , "'Unable to find Role with role_id '.$roles");
        }

        //Check if Users have this role_id
        $role = \Sentinel::findRoleById($roles);
        if($role->users()->with('roles')->first()) {
            return response()->error("Roma" , "Users are assigned to this role, unable to delete role, Make sure to remove this role from all Users");
        }

        //Destroy Role
        Sentinel::findRoleById($response->role_id)->delete();
        return response()->success();
    }
}
