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
                return response()->success(404);
            }
            return $role;
        } catch (Exception $e) {
            return response()->error(500);
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
        $slug = strtolower($request->name);
        $name = $request->name;

        if (\Sentinel::findRoleBySlug($slug) || \Sentinel::findRoleByName($name)) {
            return response()->error(409);
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
     * @param  int  $roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $roles)
    {
         //Check if Role Id exists
         if (!\Sentinel::findRoleById($roles)) {
             return response()->error("Remi" , "Unable to find Role with role_id ".$roles);
         }

         $role = \Sentinel::findRoleById($roles);

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
        //Check if Role Id exists
        if (!\Sentinel::findRoleById($roles)) {
            return response()->error(404);
        }

        //Check if Users have this role_id
        $role = \Sentinel::findRoleById($roles);
        if($role->users()->with('roles')->first()) {
            return response()->error("404" , "Users are assigned to this role, unable to delete role, Make sure to remove this role from all Users");
        }

        if ($roles == 1) {
            return response()->error(406);
        }

        //Destroy Role
        \Sentinel::findRoleById($roles)->delete();
        return response()->success();
    }
}
