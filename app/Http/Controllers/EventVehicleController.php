<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Models\Vehicle;
use App\Models\Event;

class EventVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($events, Request $request)
    {
       try {
            return Event::find($events)->vehicles()->wherePivot('type', $request->type)->get();
        } catch (Exception $e){
            return response()->error("500" , $e);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($events, Request $request)
    {
        try {
            $vehicle = Vehicle::create($request->all());

            //Storing new objects into pivot table.
            //Creating the pivot between event & vehicle
            Event::find($events)
                    ->vehicles()
                    ->attach($vehicle, ['type' => $request->type]);

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
    public function update($events, Request $request)
    {
        try {
            $newVehicleData = array (
                'name' => $request->name,
                'passenger_count' => $request->passenger_count,
                'capacity' => $request->capacity
            );
            Vehicle::where('id', $id)->update($newVehicleData);

            //Updating Pivot Table
            Event::find($events)
                    ->vehicles()
                    ->updateExistingPivot($id , ['type' => $request->type]);
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
    public function destroy($eid, $id)
    {
        try {
            $vehicle = Vehicle::find($id);
            if (count($vehicle->passengers()->get())) {
                return response()->error("409" , "Passengers still in this Vehicle");
            }

            $vehicle->find($id)
                    ->events()
                    ->detach();

            $vehicle->delete();
            return response()->success();
        } catch (Exception $e) {
            return response()->error("500" , $e);
        }
    }
}
