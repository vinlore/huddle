<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Accommodation as Accommodation;

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
         $role = \Sentinel::findRoleById($response->id);

         //Convert into String, then back into array
         //Place array into the roles permissions
         $role->permissions = json_decode(json_encode($response->permissions), True);
         $role->save();

         return $role;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
