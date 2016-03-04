<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    // Each profile belongs to one user.
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // Each profile attends many conferences.
    public function conferences()
    {
        return $this->belongsToMany('App\Models\Conference', 'profile_attends_conferences');
    }

    // Each profile attends many events.
    public function events()
    {
        return $this->belongsToMany('App\Models\Event', 'profile_attends_events');
    }

    // Each profile stays in many rooms.
    public function rooms()
    {
        return $this->belongsToMany('App\Models\Room', 'profile_stays_in_rooms');
    }

    // Each profile is transported by many vehicles.
    public function vehicles()
    {
        return $this->belongsToMany('App\Models\Room', 'profile_stays_in_rooms');
    }
}
