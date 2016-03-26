<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Models\Vehicle as Vehicle;
use App\Models\Conference as Conference;
use App\Models\Event as Event;

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
                return response()->success("204" , "No Vehicles Found.");
            }
            return $vehicle;
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
    public function store(Request $request, $type)
    {
        try {
            $vehicle = Vehicle::create($request->all());

            //Storing new objects into pivot table.
            if ($type == 'conference') {
                //Creating the pivot between conf & vehicle
                Conference::find($request->conference_id)
                            ->vehicles()
                            ->attach($vehicle, ['type' => $request->type]);
            } elseif ($type == 'event') {
                //Creating the pivot between event & vehicle
                Event::find($request->event_id)
                        ->vehicles()
                        ->attach($vehicle, ['type' => $request->type]);
            } else {
                return response()->error("400" , "What are you creating for?");
            }

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
    public function update(Request $request, $id, $type)
    {
        try {
            $newVehicleData = array (
                'name' => $request->name,
                'passenger_count' => $request->passenger_count,
                'capacity' => $request->capacity
            );
            Vehicle::where('id', $id)->update($newVehicleData);

            //Updating Pivot Table
            if ($type == 'conference') {
                Conference::find($request->conference_id)
                            ->vehicles()
                            ->updateExistingPivot($id,['type' => $request->type]);
            } elseif ($type == 'event') {
                Event::find($request->event_id)
                        ->vehicles()
                        ->updateExistingPivot($id , ['type' => $request->type]);
            } else {
                response()->error("400" , "What are you trying to update?");
            }
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
    public function destroy($id)
    {
        try {
            $vehicle = Vehicle::findorfail($id);
            if ($vehicle->passengers()->count()){
                return response()->error("409" , "Passengers still in this Vehicle");
            }

            //Remove the Pivot Row - From Conference/Event - Vehicles
            Vehicle::find($id)
                    ->conferences()
                    ->detach();

            Vehicle::find($id)
                    ->events()
                    ->detach();

            Vehicle::destroy($id);
            return response()->success();
        } catch (Exception $e) {
            return response()->error("500" , $e);
        }
    }
}
