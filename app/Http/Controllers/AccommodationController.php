<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Models\Accommodation as Accommodation;

class AccommodationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Not included in API document
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            Accommodation::create($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error("Aceso", $e);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return Accommodation::find($id);
        } catch (Exception $e){
            return response()->error("Acheloisthe", $e);
        }
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
        try {
            $new_accomodation_data = array(
                'name' => $request->name,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country
            );
            Accommodation::where('id',$id)->update($new_accomodation_data);
            return response()->success();
        } catch (Exception $e) {
            return response()->error("Achelous", $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $accom = Accommodation::findorfail($id);
            if ($accom->rooms()->count()){
                return response()->error("409" , "Rooms still in this Accomodation");
            }
            Accommodation::destroy($id);
            return response()->success();
        } catch (Exception $e) {
            return response()->error("500" , $e);
        }
    }

}
