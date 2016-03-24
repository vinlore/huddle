<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


use App\Http\Requests;

use App\Models\Profile as Profile;

class ProfileController extends Controller
{
    /**
     * Get the resource
     *
     * @param  int  $users
     * @return \Illuminate\Http\Response
     */
    public function index($users)
    {
        try {
            $profile = Profile::where('user_id', '=', $users)->first();
            return $profile;
        } catch (Exception $e) {
            return response()->error("Paeon" , $e);
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
        try {
            Profile::create($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error("Pallas" , $e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $users
     * @param  int  $profiles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $users, $profiles)
    {
        try {
            Profile::where('id', $profiles)->update($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error("Pan" , $e);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profile = Profile::findorfail($id);
        if ($profile->is_owner == 1) {
            return response()->error("409" , "Owner accounts cannot be deleted");
        } else {
            Profile::destroy($id);
            return response()->success();
        }



    }
}
