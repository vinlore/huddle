<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
<<<<<<< HEAD
=======
    // Each event has many transportation options.
    public function transportation()
    {
        return $this->belongsToMany('App\Models\Vehicle', 'event_vehicles');
    }

>>>>>>> 4a088ee9cf28f236ba4119d2446e1b3b89e4e540
    // Each event belongs to one conference.
    public function conference()
    {
        return $this->belongsTo('App\Models\Conference');
    }

    // Each event has many managers.
    public function managers()
    {
        return $this->belongsToMany('App\Models\User', 'user_manages_events');
    }

    // Each conference has many attendees.
    public function attendees()
    {
        return $this->belongsToMany('App\Models\Profile', 'profile_attends_events');
    }
}
