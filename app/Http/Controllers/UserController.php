<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{

    public function index(UserRequest $request)
    {
        // TODO pagination - Should only get certain rows
        try {
            // Search users by username if $request->username is provided, then eliminate everything but letters and numbers
            $username = preg_replace('/[^A-Za-z0-9]/', '', $request->username);
            return User::where('username', 'like', '%'.$username.'%')->with('roles')->get(['id', 'username', 'email', 'permissions']);
        } catch (Exception $e) {
            return response()->error("500" , $e);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UserRequest $request, $id)
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
    public function update(UserRequest $request, $users)
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

        try {
            //Check if Role Id exists
            if(!\Sentinel::findRoleById($request->role_id))
            {
                return response()->error(404);
            }

            //Check if User Id Exists
            if(!\Sentinel::findUserById($users))
            {
                return response()->error(404);
            }

            //Update Role first
            $user = \Sentinel::findById($users);
            $role = \Sentinel::findRoleById($request->role_id);

            $user->roles()->sync([$role->id]);

            //Update Permissions next
            $user->permissions = json_decode(json_encode($request->permissions), True);
            $user->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error("500" , $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRequest $request, $id)
    {
        //Not Allowed to destroy
    }

    //Password reset
    public function resetPassword(UserRequest $request)
    {
        try {
            $user = Sentinel::findById($request->header('ID'));

            if ($reminder = Reminder::complete($user, $request->code, $request->password))
            {
            // Reminder was successfull
            return response()->success();
            }
        } catch (Exception $e) {
            return response()->error("500" , $e);
        }
    }
}
