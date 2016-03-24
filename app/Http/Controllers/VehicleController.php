<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Models\Vehicle as Vehicle;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $vehicle = Vehicle::all();
            //Check if Vehicles Exists
            if (!$vehicle) {
                return response()->success("Sabazius" , "No Vehicles Found.");
            }
            return $vehicle;
        } catch (Exception $e){
            return response()->error("Salmoneus" , $e);
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
            Vehicle::create($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error("Viper" , $e);
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
            $vehicle = Vehicle::find($id);
            //Check if the item Exists
            if (!$vehicle) {
                return response()->error("Vulture" , "Item could not be found.");
            }
            return $vehicle;
        } catch (Exception $e) {
            return response()->error("Vine" , $e);
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
            $newVehicleData = array (
                'name' => $request->name,
                'passenger_count' => $request->passenger_count,
                'capacity' => $request->capacity
            );
            Vehicle::where('id', $id)->update($newVehicleData);
            return response()->success();
        } catch (Exception $e) {
            return response()->error("Violet" , $e);
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
        //
    }
}
