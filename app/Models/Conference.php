<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    // Each conference has one inventory.
    public function inventory()
    {
        return $this->hasOne('App\Models\Inventory');
    }

    // Each conference has many accommodations.
    public function accommodations()
    {
        return $this->belongsToMany('App\Models\Accommodation');
    }

<<<<<<< HEAD
=======
    // Each conference has many transportation options.
    public function transportation()
    {
        return $this->belongsToMany('App\Models\Vehicle', 'conference_vehicles');
    }

>>>>>>> 4a088ee9cf28f236ba4119d2446e1b3b89e4e540
    // Each conference has many events.
    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }

    // Each conference has many managers.
    public function managers()
    {
        return $this->belongsToMany('App\Models\User', 'user_manages_conferences');
    }

    // Each conference has many attendees.
    public function attendees()
    {
        return $this->belongsToMany('App\Models\Profile', 'profile_attends_conferences');
    }
}
