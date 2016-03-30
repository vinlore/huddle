<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Models\Vehicle as Vehicle;
use App\Models\Conference as Conference;

class ConferenceVehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($conferences, Request $request)
    {
        try {
            return Conference::find($conferences)->vehicles()->wherePivot('type', $request->type)->get();
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
    public function store($conferences, Request $request)
    {
        try {
            // Check if the Conference exists.
            $conf = Conference::find($conferences);
            if (!$conf) {
                return response()->error(404);
            }

            //Check if conference manager belongs to this conference OR admin
            $userId = $request->header('ID');
            if (!$conf->managers()->where('user_id', $userID)->get() ||
                Sentinel::findById($userId)->roles()->first()->name != 'System Administrator') {
                return response()->error("403" , "Permission Denied");
            }

            $vehicle = Vehicle::create($request->all());

            //Storing new objects into pivot table.
            //Creating the pivot between conf & vehicle
            $conf->vehicles()
                 ->attach($vehicle, ['type' => $request->type]);
            return response()->success();
        } catch (Exception $e) {
            return response()->error(500 , $e);
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
            return response()->error(500 , $e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($conferences, Request $request)
    {
        try {
            // Check if the Conference exists.
            $conf = Conference::find($conferences);
            if (!$conf) {
                return response()->error(404);
            }

            //Check if conference manager belongs to this conference OR admin
            $userId = $request->header('ID');
            if (!$conf->managers()->where('user_id', $userID)->get() ||
                Sentinel::findById($userId)->roles()->first()->name != 'System Administrator') {
                return response()->error("403" , "Permission Denied");
            }

            $newVehicleData = array (
                'name' => $request->name,
                'passenger_count' => $request->passenger_count,
                'capacity' => $request->capacity
            );
            Vehicle::where('id', $id)->update($newVehicleData);

            //Updating Pivot Table
            $conf->vehicles()
                 ->updateExistingPivot($id,['type' => $request->type]);
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
    public function destroy($conferences, $vehicles)
    {
        try {
            // Check if the Conference exists.
            $conf = Conference::find($conferences);
            if (!$conf) {
                return response()->error(404);
            }

            //Check if conference manager belongs to this conference OR admin
            $userId = $request->header('ID');
            if (!$conf->managers()->where('user_id', $userID)->get() ||
                Sentinel::findById($userId)->roles()->first()->name != 'System Administrator') {
                return response()->error("403" , "Permission Denied");
            }


            $vehicle = Vehicle::find($vehicles);
            if (!$vehicle) {
                return response()->error(404);
            }

            if ($vehicle->passengers()->count()){
                return response()->error("409" , "Passengers still in this Vehicle");
            }

            //Remove the Pivot Row - From Conference/Event - Vehicles
            $vehicle->conferences()
                    ->detach();

            Vehicle::destroy($vehicles);
            return response()->success();
        } catch (Exception $e) {
            return response()->error("500" , $e);
        }
    }
}
