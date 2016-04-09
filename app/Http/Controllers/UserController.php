<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Sentinel;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserRequest;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Retrieve all Users with usernames similar to a search string.
     *
     * @param  UserRequest  $request
     * @return Collection|Response
     */
    public function index(UserRequest $request)
    {
        try {
            $NON_ALPHA_NUM = '/[^A-Za-z0-9]/';
            $query = preg_replace($NON_ALPHA_NUM, '', $request->username);
            return User::where('username', 'like', '%'.$query.'%')
                       ->with('roles')
                       ->paginate(10);
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update a User.
     *
     * @param  UserRequest  $request
     * @param  int  $uid
     * @return Response
     */
    public function update(UserRequest $request, $uid)
    {
        try {
            $user = Sentinel::findById($uid);
            if (!$user) {
                return response()->error(404, 'User Not Found');
            }

            $rid = $request->role_id;
            $role = Sentinel::findRoleById($rid);
            if (!$role) {
                return response()->error(404, 'Role Not Found');
            }

            $user->roles()->sync([$rid]);
            $user->permissions = $request->permissions;
            $user->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update the password of a User.
     *
     * @param  UserRequest  $request
     * @param  int  $uid
     * @return Response
     */
    public function updatePassword(UpdatePasswordRequest $request, $uid)
    {
        try {
            // Make sure the user updating the password is the user themselves
            // or a System Administrator.
            $initiator = $request->header('ID');
            if ($initiator != $uid) {
                if (!$this->isSuperuser($request)) {
                    return response()->error(403);
                }
            }

            $user = Sentinel::findById($uid);
            if (!$user) {
                return response()->error(404, 'User Not Found');
            }

            // Verify that the old password matches their current password in
            // the database.
            $oldPassword = [
                'password' => $request->old_password,
            ];
            if (!Sentinel::validateCredentials($user, $oldPassword)) {
                return response()->error(422, 'Incorrect old password!');
            }

            // Change their password to the new password.
            $newPassword = [
                'password' => $request->new_password,
            ];
            Sentinel::update($user, $newPassword);

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
