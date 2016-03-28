<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\AccommodationRequest;
use App\Models\Accommodation;
use App\Models\Conference;

class AccommodationController extends Controller
{
    public function index($conferences)
    {
        try {
            $conf = Conference::find($conferences);
            if (!$conf) {
                return response()->success("204" , "No Conference Found");
            }
            return $conf->accommodations()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }


    public function store(AccommodationRequest $request, $conferences)
    {
        try {
            $accommodation = Accommodation::create($request->all());
            $accommodation->conferences()->attach($conferences);
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function show($conferences, $id)
    {
        try {
            $accom = Accommodation::find($id);
            if (!$accom) {
                return response()->success("204" , "No Accomodation found");
            }
            return $accom;
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function update(AccommodationRequest $request, $conferneces, $id)
    {
        try {
            $accom = Accommodation::find($id);
            if(!$accom) {
                return response()->error("204" , "Unable to find the accommodation to update");
            }
            $accom->update($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function destroy($conferences, $id)
    {
        try {
            $accommodation = Accommodation::find($id);
            if ($accommodation->rooms()->guests()->count()) {
                return response()->error("There are still guests in this accommodation");
            }
            $accommodation->conferences()->detach();
            $accommodation->delete();
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
