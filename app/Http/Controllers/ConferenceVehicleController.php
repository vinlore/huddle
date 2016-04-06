<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\VehicleRequest;

use App\Models\Conference;
use App\Models\Vehicle;

class ConferenceVehicleController extends Controller
{
    /**
     * Retrieve all Vehicles of a Conference.
     *
     * @return Collection|Response
     */
    public function index($cid, Request $request)
    {
        try {
            return Conference::find($cid)->vehicles()->wherePivot('type', $request->type)->get();
        } catch (Exception $e){
            return response()->error("500" , $e);
        }
    }

    /**
     * Create a Vehicle for a Conference.
     *
     * @return Response
     */
    public function store($cid, Request $request)
    {
        try {
            // Check if the Conference exists.
            $conf = Conference::find($cid);
            if (!$conf) {
                return response()->error(404);
            }

            // Check if the User is managing the Conference.
            if (!$this->isConferenceManager($request, $cid)) {
                return response()->error(403);
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
     * Retrieve a Vehicle of a Conference
     *
     * @return App\Models\Vehicle|Response
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
     * Update a Vehicle of a Conference.
     *
     * @return Response
     */
    public function update($cid, Request $request)
    {
        try {
            // Check if the Conference exists.
            $conf = Conference::find($cid);
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
     * Delete a Vehicle of a Conference.
     *
     * @return Response
     */
    public function destroy(Request $request, $cid, $vehicles)
    {
        try {
            // Check if the Conference exists.
            $conf = Conference::find($cid);
            if (!$conf) {
                return response()->error(404);
            }

            //Check if conference manager belongs to this conference OR admin
            $userId = $request->header('ID');
            if (!$conf->managers()->where('user_id', $userId)->get() ||
                \Sentinel::findById($userId)->roles()->first()->name != 'System Administrator') {
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
