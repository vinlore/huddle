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
            return Conference::find($conferences)->accommodations()->get();
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
            return Accommodation::findOrFail($id);
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function update(AccommodationRequest $request, $conferneces, $id)
    {
        try {
            Accommodation::findOrFail($id)->update($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function destroy($conferences, $id)
    {
        try {
            $accommodation = Accommodation::findOrFail($id);
            if ($accommodation->rooms()->guests()->count()) {
                return response()->error();
            }
            $accommodation->conferences()->detach();
            $accommodation->delete();
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
