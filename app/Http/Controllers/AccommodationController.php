<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\AccommodationRequest;
use App\Models\Accommodation;

class AccommodationController extends Controller
{
    public function index($conference)
    {
        try {
            return Accommodation::where('conference_id', $conference)->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function store(AccommodationRequest $request)
    {
        try {
            $accommodation = Accommodation::create($request->all());
            $accommodation->conferences()->attach($request->conference_id);
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function show($id)
    {
        try {
            return Accommodation::findOrFail($id);
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function update(AccommodationRequest $request, $id)
    {
        try {
            Accommodation::findOrFail($id)->update($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function destroy($id)
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
