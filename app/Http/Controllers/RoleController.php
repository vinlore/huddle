<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Cartalyst\Sentinel\Roles\EloquentRole as Role;
use Sentinel;

use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    /**
     * Retrieve all Roles.
     *
     * @param  RoleRequest  $request
     * @return Collection|Response
     */
    public function index(RoleRequest $request)
    {
        try {
            return Role::all();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create a Role.
     *
     * @param  RoleRequest  $request
     * @return Response
     */
    public function store(RoleRequest $request)
    {
        try {
            $name = $request->name;
            $slug = strtolower($name);
            $permissions = $request->permissions;

            $role = [
                'name'        => $name,
                'slug'        => $slug,
                'permissions' => $permissions,
            ];
            Role::create($role);

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update a Role.
     *
     * @param  RoleRequest  $request
     * @param  int  $rid
     * @return Response
     */
    public function update(RoleRequest $request, $rid)
    {
        try {
            $role = Role::find($rid);
            if (!$role) {
                return response()->error(404, 'Role Not Found');
            }

            $role->fill($request->all());
            $role->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete a Role.
     *
     * @param  RoleRequest  $request
     * @param  int  $rid
     * @return Response
     */
    public function destroy(RoleRequest $request, $rid)
    {
        try {
            if ($rid == 1) {
                return response()->error(403, 'System Administrator cannot be deleted!');
            }

            $role = Role::find($rid);
            if (!$role) {
                return response()->error(404, 'Role Not Found');
            }

            if ($role->users()->count()) {
                return response()->error(409, 'There are still users assigned to this role!');
            }

            $role->delete();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
