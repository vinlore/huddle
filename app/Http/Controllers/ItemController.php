<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\ItemRequest;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        try {
            return Item::all();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function store(ItemRequest $request)
    {
        try {
            Item::create($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function show($id)
    {
        try {
            return Item::findOrFail($id);
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function update(ItemRequest $request, $id)
    {
        try {
            Item::findOrFail($id)->update($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function destroy($id)
    {
        try {
            Item::findOrFail($id)->delete();
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
