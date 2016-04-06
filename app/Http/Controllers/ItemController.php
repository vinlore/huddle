<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\ItemRequest;

use App\Models\Conference;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Retrieve all Items of a Conference.
     *
     * @return Collection|Response
     */
    public function index(Request $request, $cid)
    {
        try {
            return Item::where('conference_id', $cid)->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create an Item for a Conference.
     *
     * @return Response
     */
    public function store(ItemRequest $request)
    {
        try {
            Item::create($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve an Item of a Conference
     *
     * @return App\Models\Item|Response
     */
    public function show(ItemRequest $request, $cid, $iid)
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

    /**
     * Update an Item of a Conference.
     *
     * @return Response
     */
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

    /**
     * Delete an Item of a Conference.
     *
     * @return Response
     */
    public function destroy(ItemRequest $request, $cid, $iid)
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
