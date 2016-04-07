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
     * @param  Request  $request
     * @param  int  $cid
     * @return Collection|Response
     */
    public function index(Request $request, $cid)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            return $conference->items()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create an Item for a Conference.
     *
     * @param  ItemRequest  $request
     * @param  int  $cid
     * @return Response
     */
    public function store(ItemRequest $request, $cid)
    {
        try {
            $user = $this->isConferenceManager($request, $cid);
            if (!$user) {
                return response()->error(403, 'You are not a manager of this conference!');
            }

            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $item = new Item($request->all());
            $item->conference()->associate($conference);
            $item->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve an Item of a Conference
     *
     * @param  ItemRequest  $request
     * @param  int  $cid
     * @param  int  $iid
     * @return App\Models\Item|Response
     */
    public function show(ItemRequest $request, $cid, $iid)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $item = Item::find($iid);
            if (!$item) {
                return response()->error(404, 'Item Not Found');
            }

            return $item;
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update an Item of a Conference.
     *
     * @param  ItemRequest  $request
     * @param  int  $cid
     * @param  int  $iid
     * @return Response
     */
    public function update(ItemRequest $request, $cid, $iid)
    {
        try {
            $user = $this->isConferenceManager($request, $cid);
            if (!$user) {
                return response()->error(403, 'You are not a manager of this conference!');
            }

            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $item = Item::find($iid);
            if (!$item) {
                return response()->error(404, 'Item Not Found');
            }

            $item->fill($request->all());
            $item->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete an Item of a Conference.
     *
     * @param  ItemRequest  $request
     * @param  int  $cid
     * @param  int  $iid
     * @return Response
     */
    public function destroy(ItemRequest $request, $cid, $iid)
    {
        try {
            $user = $this->isConferenceManager($request, $cid);
            if (!$user) {
                return response()->error(403, 'You are not a manager of this conference!');
            }

            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $item = Item::find($iid);
            if (!$item) {
                return response()->error(404, 'Item Not Found');
            }

            $item->delete();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
