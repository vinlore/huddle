<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\AccommodationRequest;
use App\Models\Accommodation;
use App\Models\Conference;

class AccommodationController extends Controller
{
    /**
     * Retrieve all Accommodations for a Conference.
     *
     * @return Collection|Response
     */
    public function index(Request $request, $cid)
    {
        try {

            // Check if the Conference exists.
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404);
            }

            // Retrieve its Accommodations.
            return $conference->accommodations()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create an Accommodation for a Conference.
     *
     * @return Response
     */
    public function store(AccommodationRequest $request, $cid)
    {
        try {

            $conference = Conference::find($cid);
            // Check if the Conference exists.
            if (!$conference->exists()) {
                return response()->error(404);
            }

            //Check if conference manager belongs to this conference
            $userId = $request->header('ID');
            if (!$conference->managers()->where('user_id', $userID)->get()) {
                return response()->error("403" , "Permission Denied");
            }

            // Create the Accommodation.
            $accommodation = Accommodation::create($request->all());
            $accommodation->conferences()->attach($cid);

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve an Accommodation.
     *
     * @return Model|Response
     */
    public function show(AccommodationRequest $request, $cid, $aid)
    {
        try {

            // Check if the Conference exists.
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404);
            }

            // Check if the Accommodation exists.
            $accommodation = Accommodation::find($aid);
            if (!$accommodation) {
                return response()->error(404);
            }

            // Retrieve the Accommodation.
            return $accommodation;
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update an Accommodation.
     *
     * @return Response
     */
    public function update(AccommodationRequest $request, $cid, $aid)
    {
        try {

            // Check if the Conference exists.
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404);
            }

            // Check if the Accommodation exists.
            $accommodation = Accommodation::find($aid);
            if (!$accommodation) {
                return response()->error(404);
            }

            //Check if conference manager belongs to this conference
            $userId = $request->header('ID');
            if (!$conference->managers()->where('user_id', $userID)->get()) {
                return response()->error("403" , "Permission Denied");
            }

            // Update the Accommodation.
            $accommodation->fill($request->all())->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete an Accommodation.
     *
     * @return Response
     */
    public function destroy(AccommodationRequest $request, $cid, $aid)
    {
        try {

            // Check if the Conference exists.
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404);
            }

            // Check if the Accommodation exists.
            $accommodation = Accommodation::find($aid);
            if (!$accommodation) {
                return response()->error(404);
            }

            // Check if the User is managing the Conference.
            $userId = $request->header('ID');

            //Check if conference manager belongs to this conference
            $userId = $request->header('ID');
            if (!$conference->managers()->where('user_id', $userID)->get()) {
                return response()->error("403" , "Permission Denied");
            }

            // Delete the Accommodation.
            $accommodation->delete();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
