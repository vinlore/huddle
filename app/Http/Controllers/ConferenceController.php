<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Conference as Conference;

class ConferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Conference::all();
    }

    public function dev


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){

        Conference::create($request->all());
        return \Response::json(array('status' => 'success'));
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = \Sentinel::findById(2);
        $status = null;
        $user_permissions = null;
        $role = $user->role;

        if (!is_null($request->status) && ($user_permissions == null && $role == 1)){

            Conference::find($id)
            ->update(array('status' => $request->satus));

        } elseif(is_null($request->status)){

            Conference::find($id)
            ->update(array('name' => 'lololol'));
            ->update(array('status' => 'pending'));

        }

        return \Response::json(array('status' => 'success'));
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
