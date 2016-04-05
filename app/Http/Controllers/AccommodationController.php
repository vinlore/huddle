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
     * Retrieve all Accommodations of a Conference.
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

            return $conference->accommodations()->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Create an Accommodation for a Conference.
     *
     * @param  AccommodationRequest  $request
     * @param  int  $cid
     * @return Response
     */
    public function store(AccommodationRequest $request, $cid)
    {
        try {
            $user = $this->isConferenceManager($request, $cid);
            if (!$user) {
                return response()->error(403);
            }

            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $accommodation = Accommodation::create($request->all());
            $accommodation->conferences()->attach($cid);

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Retrieve an Accommodation of a Conference.
     *
     * @param  AccommodationRequest  $request
     * @param  int  $cid
     * @param  int  $aid
     * @return App\Models\Accommodation|Response
     */
    public function show(AccommodationRequest $request, $cid, $aid)
    {
        try {
            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $accommodation = Accommodation::find($aid);
            if (!$accommodation) {
                return response()->error(404, 'Accommodation Not Found');
            }

            return $accommodation;
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Update an Accommodation of a Conference.
     *
     * @param  AccommodationRequest  $request
     * @param  int  $cid
     * @param  int  $aid
     * @return Response
     */
    public function update(AccommodationRequest $request, $cid, $aid)
    {
        try {
            $user = $this->isConferenceManager($request, $cid);
            if (!$user) {
                return response()->error(403);
            }

            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $accommodation = Accommodation::find($aid);
            if (!$accommodation) {
                return response()->error(404, 'Accommodation Not Found');
            }

            $accommodation->fill($request->all())->save();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    /**
     * Delete an Accommodation of a Conference.
     *
     * @param  AccommodationRequest  $request
     * @param  int  $cid
     * @param  int  $aid
     * @return Response
     */
    public function destroy(AccommodationRequest $request, $cid, $aid)
    {
        try {
            $user = $this->isConferenceManager($request, $cid);
            if (!$user) {
                return response()->error(403);
            }

            $conference = Conference::find($cid);
            if (!$conference) {
                return response()->error(404, 'Conference Not Found');
            }

            $accommodation = Accommodation::find($aid);
            if (!$accommodation) {
                return response()->error(404, 'Accommodation Not Found');
            }

            $accommodation->delete();

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
