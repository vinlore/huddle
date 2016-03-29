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
            return Item::findOrFail($iid);
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function update(ItemRequest $request, $cid, $iid)
    {
        try {
            Item::findOrFail($iid)->update($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function destroy($cid, $iid)
    {
        try {
            Item::findOrFail($iid)->delete();
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
