<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\ItemRequest;
use App\Models\Item;

class ItemController extends Controller
{
    public function index($cid)
    {
        try {
            return Item::where('conference_id', $cid)->get();
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

    public function show($cid, $iid)
    {
        try {
            $item = Item::find($iid);
            if (!$item) {
                return response()->error(404);
            }
            return $item;
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function update(ItemRequest $request, $cid, $iid)
    {
        try {
            $item = Item::find($iid);
            if (!$item) {
                return response()->error(404);
            }
            $item->update($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function destroy($cid, $iid)
    {
        try {
            $item = Item::find($iid);
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
