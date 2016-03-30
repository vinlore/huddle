<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\ItemRequest;
use App\Models\Item;

class ItemController extends Controller
{
    public function index($conferences)
    {
        try {
            return Item::where('conference_id', $conferences)->get();
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
            $item = Item::find($id);
            if (!$item) {
                return response()->error(404);
            }
            return $item;
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function update(ItemRequest $request, $id)
    {
        try {
            $item = Item::find($id);
            if (!$item) {
                return response()->error(404);
            }
            $item->update($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function destroy($id)
    {
        try {
            $item = Item::find($id);
            if (!$item) {
                return response()->error(404);
            }
            $item->delete();
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
