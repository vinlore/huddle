<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\EventRequest;
use App\Models\Conference;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    public function index(Request $request, $conference)
    {
        try {
            return Event::where('conference_id', $conference)->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function store(EventRequest $request)
    {
        try {
            //Check if conference exists
            $conference = Conference::find($request->conference_id);
            if (!$conference) {
                return response()->error(404);
            }

            //Check if User belongs to this event
            $userId = $request->header('ID');
            if (!$conference->managers()->where('user_id',$userID)->get() ||
                Sentinel::findById($userId)->roles()->first()->name !='System Administrator') {
                return response()->error("403" , "Permission Denied");
            }

            $event = Event::create($request->all());
            User::find($request->header('ID'))
                ->events()->attach($event->id);

            //Add Activity to log
            $this->addActivity($request->header('ID'),'request', $event->id, 'event');

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }


    public function update(EventRequest $request, $conferences, $id)
    {
        try {
            $event = Event::find($id);
            if (!$event) {
                return response()->error(404);
            }

            $conf = Conference::find($conferences);
            if (!$conf) {
                return response()->error(404);
            }

            //Check if event manager belongs to this event
            $userId = $request->header('ID');
            if (!$event->managers()->where('user_id', $userId)->get() ||
                !$conf->managers()->where('user_id',$userId)->get() ||
                (\Sentinel::findById($userId)->roles()->first()->name !='System Administrator') ||
                !User::find($userId)->hasAccess(['event.update'])) {
                return response()->error("403" , "Permission Denied");
            }

            if(($request->status == 'approved' || $request->status == 'denied') &&
               (User::find($userId)->hasAccess(['event.status']) &&
               ((Sentinel::findById($userId)->roles()->first()->name == 'System Administrator') ||
                $conf->managers()->where('user_id',$userId)->get()))){

                $conference->update($request->all());
                //Add Activity to log
                $this->addActivity($request->header('ID'),$request->status, $id, 'conference');
                //Send Status update Email
                $this->sendCreationEmail('event', $event->id, $request->status);

            }elseif(($request->status != 'approved' && $request->status != 'denied') ){
            // Update the Conference.
            $conference->fill($request->all())->save();

            //Add Activity to log
             $this->addActivity($request->header('ID'),'update', $id, 'conference');
            }else{
                return response()->error(403);
            }


            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function destroy(EventRequest $request, $conferences, $id)
    {
        try {

            $conf = Conference::find($conferences);
            if (!$conf) {
                return response()->error(404);
            }

            //Check if event manager belongs to this event OR admin
            $userId = $request->header('ID');
            if (!$event->managers()->where('user_id', $userId)->get()||
                !$conf->managers()->where('user_id',$userId)->get() ||
                Sentinel::findById($userId)->roles()->first()->name !='System Administrator') {
                return response()->error("403" , "Permission Denied");
            }

            $event = Event::find($id);
            if (!$event) {
                return response()->error("Event not found");
            }

            $event->delete();

            //Add Activity to log
            $this->addActivity($request->header('ID'),'delete', $event->id, 'event');

            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function indexWithStatus(Request $request)
    {
        try {
            return Event::where('status', $request->status)->get();
        } catch (Exception $e) {
            return response()->error();
        }
    }

    public function updateWithStatus(EventRequest $request, $id)
    {
        try {
            $event = Event::find($id);
            if (!$event) {
                return response()->error("Event not found");
            }

            $conf = Conference::find($request->conference_id);
            if (!$conf) {
                return response()->error(404);
            }

            //Check if event manager belongs to this event OR admin
            $userId = $request->header('ID');
            if (!$event->managers()->where('user_id', $userID)->get()||
                !$conf->managers()->where('user_id',$userID)->get() ||
                (Sentinel::findById($userId)->roles()->first()->name !='System Administrator') ||
                !User::find($userId)->hasAccess(['event.update'])) {
                return response()->error("403" , "Permission Denied");
            }

            $event->update([
                'status' => $request->status,
            ]);

            //Add Activity to log
            $this->addActivity($request->header('ID'),$request->status, $event->id, 'event');

            //Send Status update Email
            $this->sendCreationEmail('event', $id, $request->status);
            return response()->success();
        } catch (Exception $e) {
            return response()->error();
        }
    }
}
