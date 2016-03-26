<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\ConferenceRequest;
use App\Models\Conference;

class ConferenceController extends Controller
{
    public function index()
    {
        try {
            return Conference::all();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function store(ConferenceRequest $request)
    {
        try {
            Conference::create($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function show($id)
    {
        try {
            return Conference::findOrFail($id);
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function update(ConferenceRequest $request, $id)
    {
        try {
            Conference::findOrFail($id)->update($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function destroy($id)
    {
        try {
            Conference::findOrFail($id)->delete();
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function indexWithStatus(Request $request)
    {
        try {
            return Conference::where('status', $request->status)->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function updateWithStatus(Request $request, $id)
    {
        try {
            Conference::findOrFail($id)->update([
                'status' => $request->status,
            ]);
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
