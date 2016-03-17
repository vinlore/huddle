<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            return \Response::json(array(
                'status' => 'success',
                'profile' => $profile
            )); 
        } catch (Exception $e) {
            return \Response::json(array(
                'status' => 'error',
                'message' => $e
            ));
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
        Profile::create($request->all());
        return \Response::json(array('status' => 'success'));
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
            return \Response::json(array(
                'status' => 'success'
            ));
        } catch (Exception $e) {
            return \Response::json(array(
                'status' => 'error',
                'message' => $e
            ));
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
        //
    }
}
