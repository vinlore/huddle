<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;

use App\Models\Item as Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $item = Item::all();
            //Check if Items exists
            if (!$item) {
                return response()->success("Iris" , "No Items Exist");
            }
            return $item;
        } catch (Exception $e) {
            return response()->error("Irene" , $e);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            Item::create($request->all());
            return response()->success();
        } catch (Exception $e) {
            return response()->error("Ion", $e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $item = Item::find($id);
            //Check if the the item exists
            if (!$item) {
                return response()->success("Iris","No Item Exist");
            }
            return $item;
        } catch (Exception $e) {
            return response()->error("Icelos", $e);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $newItemData = array(
                'name' => $request->name,
                'conference_id' => $request->conference_id,
                'quantity' => $request->quantity
            );
            Item::where('id',$id)->update($newItemData);
            return response()->success();
        } catch (Exception $e) {
            return response()->error("Ino", $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Item::destroy($id);
            return response()->success();
        } catch (Exception $e) {
            return response()->error("500" , $e);
        }
    }
}
