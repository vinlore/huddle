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
        //
    }

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
       /* $new_conference_data = array(
            'name'=> $request->name,
            'description' => $request->description,
            'start_date' => $request->startDate,
            'end_date' => $request->endDate,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'attendee_count' => $request->attendee_count,
            'capacity' => $request->capacity,
            'status' => $request->status
        ); */

        if (!is_null($request->status){

            Conference::find($id)
            ->update($request->all());

        } else{

            Conference::find($id)
            ->update($request->all());

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
